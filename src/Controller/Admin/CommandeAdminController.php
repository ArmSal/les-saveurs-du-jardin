<?php

namespace App\Controller\Admin;

use App\Entity\Commande;
use App\Entity\CommandeHistory;
use App\Entity\PortalNotification;
use App\Form\Admin\CommandeStatusType;
use App\Repository\CommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use Dompdf\Dompdf;
use App\Service\AccessHelper;

#[Route('/admin/commandes')]
class CommandeAdminController extends AbstractController
{
    private AccessHelper $access;

    public function __construct(AccessHelper $access)
    {
        $this->access = $access;
    }

    #[Route('', name: 'admin_commandes_index')]
    public function index(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {
        if (!$this->access->canView('commandes')) {
            throw $this->createAccessDeniedException();
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $isFullAccess = $this->access->isFullAccess('commandes');
        $isAdminMagasin = $this->access->isMagasinOnly('commandes') || $isFullAccess;

        $view = $request->query->get('view');
        if (!$view) {
            $view = $isFullAccess ? 'all' : ($isAdminMagasin ? 'magasin' : 'my');
        }

        // Security check for view
        if ($view === 'all' && !$isFullAccess) {
            $view = 'magasin';
        }
        if ($view === 'magasin' && !$isAdminMagasin) {
            $view = 'my';
        }

        $queryBuilder = $em->getRepository(Commande::class)->createQueryBuilder('c')
            ->join('c.user', 'u')
            ->orderBy('c.createdAt', 'DESC');

        if ($view === 'my') {
            $queryBuilder->andWhere('u.id = :me')
                ->setParameter('me', $user->getId());
        } elseif ($view === 'magasin') {
            $queryBuilder->andWhere('u.magasin = :my_mag')
                ->setParameter('my_mag', $user->getMagasin());
        }
        // 'all' has no extra filter

        $status = $request->query->get('status');
        if ($status && $status !== 'all') {
            $queryBuilder->andWhere('c.status = :status')
                ->setParameter('status', $status);
        }

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('admin/commande/index.html.twig', [
            'commandes' => $pagination,
            'currentView' => $view,
            'currentStatus' => $status ?: 'all',
            'isFullAccess' => $isFullAccess,
            'isAdminMagasin' => $isAdminMagasin,
            'statusLabels' => Commande::STATUS_LABELS_FR,
            'notifications' => $em->getRepository(PortalNotification::class)->findLatestForUser($user, 5),
            'unreadNotificationsCount' => $em->getRepository(PortalNotification::class)->countUnreadForUser($user),
        ]);
    }

    /**
     * AJAX endpoint: returns only the commandes table+pagination fragment.
     * Called by fetch() on status/view change so the page never fully reloads.
     */
    #[Route('/ajax', name: 'admin_commandes_ajax', methods: ['GET'])]
    public function ajax(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {
        if (!$this->access->canView('commandes')) {
            return new Response('', 403);
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $isFullAccess   = $this->access->isFullAccess('commandes');
        $isAdminMagasin = $this->access->isMagasinOnly('commandes') || $isFullAccess;

        $view = $request->query->get('view', $isFullAccess ? 'all' : ($isAdminMagasin ? 'magasin' : 'my'));
        if ($view === 'all' && !$isFullAccess) $view = 'magasin';
        if ($view === 'magasin' && !$isAdminMagasin) $view = 'my';

        $qb = $em->getRepository(Commande::class)->createQueryBuilder('c')
            ->join('c.user', 'u')
            ->orderBy('c.createdAt', 'DESC');

        if ($view === 'my') {
            $qb->andWhere('u.id = :me')->setParameter('me', $user->getId());
        } elseif ($view === 'magasin') {
            $qb->andWhere('u.magasin = :mag')->setParameter('mag', $user->getMagasin());
        }

        $status = $request->query->get('status');
        if ($status && $status !== 'all') {
            $qb->andWhere('c.status = :status')->setParameter('status', $status);
        }

        $pagination = $paginator->paginate(
            $qb,
            $request->query->getInt('page', 1),
            12
        );

        return $this->render('admin/commande/_list.html.twig', [
            'commandes'    => $pagination,
            'currentView'  => $view,
            'currentStatus'=> $status ?: 'all',
            'statusLabels' => Commande::STATUS_LABELS_FR,
        ]);
    }

    #[Route('/{id}', name: 'admin_commandes_show')]
    public function show(Commande $commande, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->access->canView('commandes')) {
            throw $this->createAccessDeniedException();
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $isFullAccess = $this->access->isFullAccess('commandes');

        // Security check: if not full access, must match personal or store
        if (!$isFullAccess) {
            $isSameMagasin = ($commande->getUser()->getMagasin() === $user->getMagasin());
            $isAdminMagasin = $this->access->isMagasinOnly('commandes');
            
            if ($commande->getUser() !== $user && (!$isAdminMagasin || !$isSameMagasin)) {
                throw $this->createAccessDeniedException('Accès refusé à cette commande.');
            }
        }

        $isLocked = in_array($commande->getStatus(), [Commande::STATUS_ARCHIVED, Commande::STATUS_CANCELED]);
        $oldStatus = $commande->getStatus();

        $form = $this->createForm(CommandeStatusType::class, $commande);

        if (!$isLocked && $isFullAccess) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if ($commande->getStatus() !== $oldStatus) {
                    $history = new CommandeHistory();
                    $history->setCommande($commande);
                    $history->setStatus($commande->getStatus());
                    $history->setChangedBy($user);
                    $em->persist($history);

                    $notif = new PortalNotification();
                    $notif->setUser($commande->getUser());
                    $notif->setTitle('Statut de Commande Update');
                    $notif->setContent(sprintf('Statut mis à jour : %s.', $commande->getStatusLabelFr()));
                    $notif->setLink('/commande/my');
                    $notif->setType('ORDER_STATUS');
                    $em->persist($notif);
                }
                $em->flush();
                return $this->redirectToRoute('admin_commandes_show', ['id' => $commande->getId()]);
            }
        }

        return $this->render('admin/commande/show.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
            'isLocked' => $isLocked,
            'isFullAccess' => $isFullAccess,
            'notifications' => $em->getRepository(PortalNotification::class)->findLatestForUser($user, 5),
            'unreadNotificationsCount' => $em->getRepository(PortalNotification::class)->countUnreadForUser($user),
        ]);
    }

    #[Route('/{id}/update-item/{itemId}', name: 'admin_commandes_update_item', methods: ['POST'])]
    public function updateItem(Commande $commande, int $itemId, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->access->isFullAccess('commandes')) {
            throw $this->createAccessDeniedException('Seul l\'accès total permet de modifier les quantités.');
        }

        if (in_array($commande->getStatus(), [Commande::STATUS_ARCHIVED, Commande::STATUS_CANCELED])) {
            $this->addFlash('error', 'Commande verrouillée.');
            return $this->redirectToRoute('admin_commandes_show', ['id' => $commande->getId()]);
        }

        $item = $em->getRepository(\App\Entity\CommandeItem::class)->find($itemId);
        if (!$item || $item->getCommande() !== $commande) {
            throw $this->createNotFoundException('Item not found');
        }

        $newQty = (int) $request->request->get('quantity');
        $productName = $item->getProduct()->getDesignation();
        $oldQty = $item->getQuantity();

        if ($newQty === 0) {
            $em->remove($item);
            
            // Log item deletion to history
            $history = new CommandeHistory();
            $history->setCommande($commande);
            $history->setStatus('item_deleted');
            $history->setDetail(sprintf('Produit "%s" supprimé (qté était: %d)', $productName, $oldQty));
            $history->setChangedBy($this->getUser());
            $em->persist($history);
            
            $em->flush();
            $this->addFlash('success', sprintf('"%s" supprimé.', $productName));
        } elseif ($newQty > 0 && $newQty !== $oldQty) {
            $item->setQuantity($newQty);
            
            // Log quantity change to history
            $history = new CommandeHistory();
            $history->setCommande($commande);
            $history->setStatus('quantity_updated');
            $history->setDetail(sprintf('Produit "%s": qté %d → %d', $productName, $oldQty, $newQty));
            $history->setChangedBy($this->getUser());
            $em->persist($history);
            
            $em->flush();
            $this->addFlash('success', 'Quantité mise à jour.');
        }

        return $this->redirectToRoute('admin_commandes_show', ['id' => $commande->getId()]);
    }

    #[Route('/{id}/receipt', name: 'admin_commandes_receipt')]
    public function receipt(Commande $commande): Response
    {
        if (!$this->access->canView('commandes')) {
            throw $this->createAccessDeniedException();
        }

        /** @var \App\Entity\User $user */
        $user = $this->getUser();
        $isFullAccess = $this->access->isFullAccess('commandes');

        if (!$isFullAccess && $commande->getUser() !== $user && ($commande->getUser()->getMagasin() !== $user->getMagasin() || !$this->access->isMagasinOnly('commandes'))) {
            throw $this->createAccessDeniedException();
        }

        $logoPath = $this->getParameter('kernel.project_dir') . '/public/logo.svg';
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/svg+xml;base64,' . base64_encode($logoData);
        }

        // Magasin addresses mapping
        $magasinAddresses = [
            'Olivet' => [
                'name' => 'LSDJ OLIVET',
                'line1' => '1410 Rue de la Bergeresse',
                'line2' => '45160 Olivet',
                'full' => '1410 Rue de la Bergeresse, 45160 Olivet',
            ],
            'St Gervais' => [
                'name' => 'LSDJ ST GERVAIS',
                'line1' => '113B Route Nationale',
                'line2' => '41350 Saint-Gervais-la-Forêt',
                'full' => '113B Rte Nationale, 41350 Saint-Gervais-la-Forêt',
            ],
            'Villemandeur' => [
                'name' => 'LSDJ VILLEMANDEUR',
                'line1' => '69 Rue Jean Mermoz',
                'line2' => '45700 Villemandeur',
                'full' => '69 Rue Jean Mermoz, 45700 Villemandeur',
            ],
            'Saran' => [
                'name' => 'LSDJ SARAN',
                'line1' => '1111 Route Nationale 20',
                'line2' => '45770 Saran',
                'full' => '1111 Route Nationale 20, 45770 Saran',
            ],
            'Noyers' => [
                'name' => 'LSDJ NOYERS',
                'line1' => '14 Rue André Boulle',
                'line2' => '41140 Noyers-sur-Cher',
                'full' => '14 Rue André Boulle, 41140 Noyers-sur-Cher',
            ],
        ];

        $magasinName = $commande->getUser()->getMagasin();
        $magasinInfo = $magasinAddresses[$magasinName] ?? [
            'name' => 'LSDJ ' . strtoupper($magasinName),
            'line1' => '',
            'line2' => '',
            'full' => $magasinName,
        ];

        // Always use Olivet address for header
        $headerAddress = $magasinAddresses['Olivet']['full'];

        $html = $this->renderView('admin/commande/receipt_pdf.html.twig', [
            'commande' => $commande,
            'logoBase64' => $logoBase64,
            'currentUser' => $user,
            'magasinInfo' => $magasinInfo,
            'headerAddress' => $headerAddress,
        ]);

        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A5', 'portrait');
        $dompdf->render();

        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('inline; filename="bon-%s.pdf"', $commande->getId()),
            ]
        );
    }
}
