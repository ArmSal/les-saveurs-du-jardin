<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\CommandeItem;
use App\Entity\PortalNotification;
use App\Entity\User;
use App\Form\CommandeType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;

class CommandeController extends AbstractController
{
    #[Route('/commande/new', name: 'app_commande_new')]
    public function new(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();
        if (!$user instanceof User) {
            throw $this->createAccessDeniedException();
        }

        $commande = new Commande();
        $commande->setUser($user);
        $commande->addItem((new CommandeItem())->setQuantity(1));

        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($commande);
            $em->flush();

            return $this->redirectToRoute('app_commande_my');
        }

        return $this->render('commande/new.html.twig', [
            'form' => $form,
            'notifications' => $em->getRepository(PortalNotification::class)->findLatestForUser($user, 5),
            'unreadNotificationsCount' => $em->getRepository(PortalNotification::class)->countUnreadForUser($user),
        ]);
    }

    #[Route('/commande/my', name: 'app_commande_my')]
    public function my(EntityManagerInterface $em, PaginatorInterface $paginator, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $queryBuilder = $em->getRepository(Commande::class)->createQueryBuilder('c')
            ->where('c.user = :user')
            ->setParameter('user', $this->getUser())
            ->orderBy('c.createdAt', 'DESC');

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('commande/my.html.twig', [
            'commandes' => $pagination,
            'notifications' => $em->getRepository(PortalNotification::class)->findLatestForUser($this->getUser(), 5),
            'unreadNotificationsCount' => $em->getRepository(PortalNotification::class)->countUnreadForUser($this->getUser()),
        ]);
    }

    #[Route('/commande/{id}', name: 'app_commande_show')]
    public function show(Commande $commande, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if ($commande->getUser() !== $this->getUser()) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
            'notifications' => $em->getRepository(PortalNotification::class)->findLatestForUser($this->getUser(), 5),
            'unreadNotificationsCount' => $em->getRepository(PortalNotification::class)->countUnreadForUser($this->getUser()),
        ]);
    }
}


