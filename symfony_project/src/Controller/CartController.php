<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeItem;
use App\Entity\PortalProduct;
use App\Entity\PortalNotification;
use App\Entity\User;
use App\Service\CartService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    private const SESSION_KEY = 'cart_items';

    public function __construct(
        private CartService $cartService
    ) {}

    #[Route('/cart', name: 'app_cart_index')]
    public function index(SessionInterface $session, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $cart = $this->getCart($session);

        $items = [];
        $total = 0;

        foreach ($cart as $itemId => $qty) {
            $portalProduct = $em->getRepository(PortalProduct::class)->find((int) $itemId);
            if (!$portalProduct) {
                continue;
            }

            $lineTotal = (float) $portalProduct->getPrix() * (int) $qty;
            $total += $lineTotal;

            $items[] = [
                'item' => $portalProduct,
                'qty' => (int) $qty,
                'lineTotal' => $lineTotal,
            ];
        }

        return $this->render('cart/index.html.twig', [
            'items' => $items,
            'total' => $total,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'app_cart_add', methods: ['POST'])]
    public function add(PortalProduct $item, Request $request, SessionInterface $session): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if (!$this->isCsrfTokenValid('cart_add_' . $item->getId(), (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $qty = max(1, (int) $request->request->get('qty', 1));

        $cart = $this->getCart($session);
        $id = (string) $item->getId();
        $cart[$id] = ($cart[$id] ?? 0) + $qty;
        $session->set(self::SESSION_KEY, $cart);

        $this->addFlash('success', 'Added to cart');

        return $this->redirectToRoute('app_produit_index');
    }

    #[Route('/cart/remove/{id}', name: 'app_cart_remove', methods: ['POST'])]
    public function remove(PortalProduct $item, Request $request, SessionInterface $session): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if (!$this->isCsrfTokenValid('cart_remove_' . $item->getId(), (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $cart = $this->getCart($session);
        unset($cart[(string) $item->getId()]);
        $session->set(self::SESSION_KEY, $cart);

        $this->addFlash('success', 'Removed from cart');

        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/cart/update/{id}', name: 'app_cart_update', methods: ['POST'])]
    public function update(PortalProduct $item, Request $request, SessionInterface $session, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if (!$this->isCsrfTokenValid('cart_update_' . $item->getId(), (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $qty = (int) $request->request->get('qty', 1);
        $cart = $this->getCart($session);
        $id = (string) $item->getId();

        if ($qty <= 0) {
            unset($cart[$id]);
        } else {
            $cart[$id] = $qty;
        }

        $session->set(self::SESSION_KEY, $cart);

        // AJAX Support
        if ($request->isXmlHttpRequest() || str_contains($request->headers->get('Accept') ?? '', 'application/json')) {
            $totals = $this->cartService->getTotals();
            $lineSubtotal = (float)$item->getPrix() * $qty;
            
            return $this->json([
                'success' => true,
                'itemId' => $item->getId(),
                'qty' => $qty,
                'lineSubtotal' => number_format($lineSubtotal, 2, ',', ' '),
                'subtotalHT' => number_format($totals['subtotal'], 2, ',', ' '),
                'tva' => number_format($totals['tva'], 2, ',', ' '),
                'totalTTC' => number_format($totals['totalTTC'], 2, ',', ' '),
                'totalItems' => $totals['totalItems'],
                'uniqueCount' => $totals['uniqueCount'],
                'removed' => $qty <= 0
            ]);
        }

        return $this->redirectToRoute('app_cart_index');
    }

    #[Route('/cart/checkout', name: 'app_cart_checkout', methods: ['POST'])]
    public function checkout(Request $request, SessionInterface $session, EntityManagerInterface $em, \App\Service\AccessHelper $accessHelper): RedirectResponse
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if (!$this->isCsrfTokenValid('cart_checkout', (string) $request->request->get('_token'))) {
            throw $this->createAccessDeniedException();
        }

        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $cart = $this->getCart($session);
        if (count($cart) === 0) {
            $this->addFlash('error', 'Your cart is empty');
            return $this->redirectToRoute('app_cart_index');
        }

        $commande = new Commande();
        $commande->setUser($user);

        foreach ($cart as $itemId => $qty) {
            $portalProduct = $em->getRepository(PortalProduct::class)->find((int) $itemId);
            if (!$portalProduct) {
                continue;
            }

            $commandeItem = new CommandeItem();
            $commandeItem->setProduct($portalProduct);
            $commandeItem->setQuantity((int) $qty);
            $commande->addItem($commandeItem);
        }

        $em->persist($commande);
        
        // Notification to user
        $notif = new PortalNotification();
        $notif->setUser($user);
        $notif->setTitle('Commande Confirmée');
        $notif->setContent(sprintf('Votre commande #%d a été enregistrée avec succès.', $commande->getId()));
        $notif->setLink('/commande/my');
        $notif->setType('ORDER_CONFIRMED');
        $em->persist($notif);

        // Notification to Admins (of the same magasin or Master Admins)
        $allUsers = $em->getRepository(User::class)->findAll();
        $admins = [];
        foreach ($allUsers as $candidate) {
            if ($accessHelper->canEdit('commandes', $candidate)) {
                if (!$accessHelper->isMagasinOnly('commandes', $candidate) || $candidate->getMagasin() === $user->getMagasin()) {
                    $admins[] = $candidate;
                }
            }
        }

        foreach ($admins as $admin) {
            $notif = new PortalNotification();
            $notif->setUser($admin);
            $notif->setTitle('Nouvelle Commande');
            $notif->setContent(sprintf('%s a passé une nouvelle commande (#%d).', $user->getPrenom(), $commande->getId()));
            $notif->setLink('/admin/commandes/' . $commande->getId());
            $notif->setType('NEW_ORDER');
            $em->persist($notif);
        }

        $em->flush();

        $session->set(self::SESSION_KEY, []);

        $this->addFlash('success', 'Commande created');
        return $this->redirectToRoute('app_commande_my');
    }

    private function getCart(SessionInterface $session): array
    {
        $cart = $session->get(self::SESSION_KEY, []);
        if (!is_array($cart)) {
            return [];
        }

        $normalized = [];
        foreach ($cart as $id => $qty) {
            $normalized[(string) $id] = max(1, (int) $qty);
        }

        return $normalized;
    }
}


