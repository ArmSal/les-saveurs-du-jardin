<?php

namespace App\Controller;

use App\Repository\PortalNotificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class NotificationController extends AbstractController
{
    #[Route('/notifications', name: 'app_notifications_index')]
    public function index(PortalNotificationRepository $notifRepo, PaginatorInterface $paginator, Request $request): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $queryBuilder = $notifRepo->createQueryBuilder('n')
            ->where('n.user = :user')
            ->setParameter('user', $user)
            ->orderBy('n.createdAt', 'DESC');

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('notification/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }
    
    #[Route('/notifications/mark-read/{id}', name: 'app_notification_mark_single_read', methods: ['POST'])]
    public function markSingleRead(\App\Entity\PortalNotification $notification, \Doctrine\ORM\EntityManagerInterface $em): \Symfony\Component\HttpFoundation\JsonResponse
    {
        if ($notification->getUser() !== $this->getUser()) {
            return new \Symfony\Component\HttpFoundation\JsonResponse(['error' => 'Unauthorized'], 403);
        }

        $notification->setRead(true);
        $em->flush();

        return new \Symfony\Component\HttpFoundation\JsonResponse(['success' => true]);
    }

    #[Route('/notifications/mark-all-read', name: 'app_notification_mark_all_read', methods: ['POST'])]
    public function markAllRead(PortalNotificationRepository $notifRepo, \Doctrine\ORM\EntityManagerInterface $em): \Symfony\Component\HttpFoundation\JsonResponse
    {
        $user = $this->getUser();
        if (!$user) {
            return new \Symfony\Component\HttpFoundation\JsonResponse(['error' => 'Unauthorized'], 403);
        }

        $unreadNotifications = $notifRepo->findBy(['user' => $user, 'isRead' => false]);
        foreach ($unreadNotifications as $notif) {
            $notif->setRead(true);
        }
        
        $em->flush();

        return new \Symfony\Component\HttpFoundation\JsonResponse(['success' => true]);
    }
}


