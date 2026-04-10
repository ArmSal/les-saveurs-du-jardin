<?php

namespace App\Twig;

use App\Entity\User;
use App\Repository\PortalNotificationRepository;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class NotificationExtension extends AbstractExtension implements GlobalsInterface
{
    private $tokenStorage;
    private $notifRepo;

    public function __construct(TokenStorageInterface $tokenStorage, PortalNotificationRepository $notifRepo)
    {
        $this->tokenStorage = $tokenStorage;
        $this->notifRepo = $notifRepo;
    }

    public function getGlobals(): array
    {
        $token = $this->tokenStorage->getToken();
        if (!$token) {
            return [];
        }
        
        $user = $token->getUser();
        if (!$user instanceof User) {
            return [];
        }

        return [
            'notifications' => $this->notifRepo->findLatestForUser($user, 5),
            'unreadNotificationsCount' => $this->notifRepo->countUnreadForUser($user),
        ];
    }
}


