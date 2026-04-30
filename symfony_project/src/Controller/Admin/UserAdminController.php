<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\PortalNotification;
use App\Entity\Magasin;
use App\Entity\Role;
use App\Entity\ModulePermission;
use App\Form\Admin\UserCreateType;
use App\Form\Admin\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use App\Service\AccessHelper;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;

#[Route('/admin/users')]
class UserAdminController extends AbstractController
{
    private AccessHelper $access;

    public function __construct(AccessHelper $access)
    {
        $this->access = $access;
    }

    #[Route('', name: 'admin_users_index')]
    public function index(Request $request, EntityManagerInterface $em, PaginatorInterface $paginator): Response
    {
        if (!$this->access->canView('users')) {
            throw $this->createAccessDeniedException();
        }

        $q = $request->query->get('q');
        $selectedMagasinId = $request->query->get('magasin');
        
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        
        // 1. Active Users Query
        $qb = $em->getRepository(User::class)->createQueryBuilder('u')
            ->andWhere('u.is_active = :active')
            ->setParameter('active', true);

        // ACCES_PERSONNEL: user can only see their own card
        $accessLevel = $this->access->getAccessLevel('users');
        $isPersonnelOnly = ($accessLevel === 'ACCES_PERSONNEL');

        if ($isPersonnelOnly) {
            $qb->andWhere('u.id = :currentUserId')
               ->setParameter('currentUserId', $currentUser->getId());
        } elseif ($this->access->isMagasinOnly('users')) {
            $qb->andWhere('u.magasinEntity = :magasin')
               ->setParameter('magasin', $currentUser->getMagasinEntity());
        } elseif ($selectedMagasinId) {
            $qb->andWhere('u.magasinEntity = :magasin')
               ->setParameter('magasin', $selectedMagasinId);
        }

        if ($q) {
            $qb->andWhere('u.nom LIKE :q OR u.prenom LIKE :q')
               ->setParameter('q', '%' . $q . '%');
        }

        $qb->orderBy('u.nom', 'ASC');
        
        $activeUsers = $paginator->paginate(
            $qb->getQuery(),
            $request->query->getInt('page', 1),
            20
        );

        // 2. Inactive Users (for bottom section)
        $qbInactive = $em->getRepository(User::class)->createQueryBuilder('u')
            ->andWhere('u.is_active = :active')
            ->setParameter('active', false);

        if ($isPersonnelOnly) {
            // ACCES_PERSONNEL: no inactive users shown
            $inactiveUsers = [];
        } else {
            if ($this->access->isMagasinOnly('users')) {
                $qbInactive->andWhere('u.magasinEntity = :magasin')
                   ->setParameter('magasin', $currentUser->getMagasinEntity());
            } elseif ($selectedMagasinId) {
                $qbInactive->andWhere('u.magasinEntity = :magasin')
                   ->setParameter('magasin', $selectedMagasinId);
            }

            if ($q) {
                $qbInactive->andWhere('u.nom LIKE :q OR u.prenom LIKE :q')
                   ->setParameter('q', '%' . $q . '%');
            }

            $inactiveUsers = $qbInactive->getQuery()->getResult();
        }

        if ($q) {
            $qbInactive->andWhere('u.nom LIKE :q OR u.prenom LIKE :q')
               ->setParameter('q', '%' . $q . '%');
        }

        $inactiveUsers = $qbInactive->getQuery()->getResult();

        return $this->render('admin/user/index.html.twig', [
            'users' => $activeUsers,
            'inactiveUsers' => $inactiveUsers,
            'selectedMagasinId' => $selectedMagasinId,
            'q' => $q,
            'notifications' => $em->getRepository(PortalNotification::class)->findLatestForUser($currentUser, 5),
            'unreadNotificationsCount' => $em->getRepository(PortalNotification::class)->countUnreadForUser($currentUser),
            'magasins' => $em->getRepository(Magasin::class)->findAll(),
            'roles' => $em->getRepository(\App\Entity\Role::class)->findBy([], ['priority' => 'ASC']),
            'accessLevel' => $accessLevel,
            'isPersonnelOnly' => $isPersonnelOnly,
        ]);
    }

    #[Route('/new', name: 'admin_users_new')]
    public function new(
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        \App\Service\ClientNumberGenerator $clientNumberGenerator,
        SluggerInterface $slugger
    ): Response {
        if (!$this->access->canEdit('users')) {
            throw $this->createAccessDeniedException();
        }

        $user = new User();

        /** @var User $currentUser */
        $currentUser = $this->getUser();
        
        // Filter roles: Only roles with STRICTLY HIGHER priority number (lower rank)
        $allRoles = $this->getAvailableRolesForPersonnel($em);
        $availableRoles = array_filter($allRoles, function($role) use ($currentUser) {
            $currentRole = $currentUser->getRoleEntity();
            return $currentRole && $currentRole->getPriority() < $role->getPriority();
        });

        $formOptions = [
            'available_roles' => $availableRoles,
        ];

        // Filter magasins if needed
        if ($this->access->isMagasinOnly('users')) {
            $formOptions['available_magasins'] = [$currentUser->getMagasinEntity()];
        }

        $form = $this->createForm(UserCreateType::class, $user, $formOptions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $submittedRole = $user->getRoleEntity();
            if ($submittedRole && !$this->canManageTargetRole($submittedRole, $user)) {
                throw $this->createAccessDeniedException('Vous ne pouvez pas créer un utilisateur avec un rôle supérieur ou égal au vôtre.');
            }

            /** @var UploadedFile $photoFile */
            $photoFile = $form->get('photo_file')->getData();
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('users_directory'),
                        $newFilename
                    );
                    $user->setPhoto($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload de la photo : ' . $e->getMessage());
                }
            }

            $plainPassword = (string) $form->get('plainPassword')->getData();
            $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));

            if (!$user->getClientNumber()) {
                $user->setClientNumber($clientNumberGenerator->generate());
            }

            /** @var User $currentUser */
            $currentUser = $this->getUser();
            if ($this->access->isMagasinOnly('users')) {
                $user->setMagasinEntity($currentUser->getMagasinEntity());
            }

            $em->persist($user);

            // Welcome Notification
            $notif = new PortalNotification();
            $notif->setUser($user);
            $notif->setTitle('Bienvenue !');
            $notif->setContent('Bienvenue sur votre plateforme LSDJ. N\'oubliez pas de compléter votre profil.');
            $notif->setLink('/settings');
            $notif->setType('WELCOME');
            $em->persist($notif);

            $em->flush();

            $this->addFlash('success', 'User created');
            return $this->redirectToRoute('admin_users_index');
        }

        return $this->render('admin/user/new.html.twig', [
            'form' => $form->createView(),
            'notifications' => $em->getRepository(PortalNotification::class)->findLatestForUser($this->getUser(), 5),
            'unreadNotificationsCount' => $em->getRepository(PortalNotification::class)->countUnreadForUser($this->getUser()),
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_users_edit')]
    public function edit(
        User $user,
        Request $request,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher,
        SluggerInterface $slugger
    ): Response {
        if (!$this->access->canEdit('users')) {
            throw $this->createAccessDeniedException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        // Magasin check
        if ($this->access->isMagasinOnly('users') && $user->getMagasin() !== $currentUser->getMagasin()) {
            throw $this->createAccessDeniedException('Vous ne pouvez modifier que les utilisateurs de votre magasin.');
        }

        $targetRole = $user->getRoleEntity();
        if ($targetRole && !$this->canManageTargetRole($targetRole, $user)) {
            throw $this->createAccessDeniedException('Vous n\'avez pas les droits pour modifier cet utilisateur.');
        }

        // Filter roles: Only roles with STRICTLY HIGHER priority number (lower rank)
        $allRoles = $this->getAvailableRolesForPersonnel($em);
        $availableRoles = array_filter($allRoles, function($role) use ($currentUser) {
            $currentRole = $currentUser->getRoleEntity();
            return $currentRole && $currentRole->getPriority() < $role->getPriority();
        });

        $formOptions = [
            'available_roles' => $availableRoles,
        ];

        // Filter magasins if needed
        if ($this->access->isMagasinOnly('users')) {
            $formOptions['available_magasins'] = [$currentUser->getMagasinEntity()];
        }

        $formOptions['is_directeur'] = ($user->getRoleEntity() && $user->getRoleEntity()->getName() === 'ROLE_DIRECTEUR');

        $form = $this->createForm(UserType::class, $user, $formOptions);

        // Pre-filling form for GET is not needed as 'roles' is mapped
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $submittedRole = $user->getRoleEntity();
            if ($submittedRole && !$this->canManageTargetRole($submittedRole, $user)) {
                throw $this->createAccessDeniedException('Vous ne pouvez pas assigner un rôle supérieur ou égal au vôtre.');
            }

            /** @var UploadedFile $photoFile */
            $photoFile = $form->get('photo_file')->getData();
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                try {
                    $photoFile->move(
                        $this->getParameter('users_directory'),
                        $newFilename
                    );
                    $user->setPhoto($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload de la photo : ' . $e->getMessage());
                }
            }

            $plainPassword = $form->get('plainPassword')->getData();
            if ($plainPassword) {
                $user->setPassword($passwordHasher->hashPassword($user, $plainPassword));
            }

            $em->flush();

            $this->addFlash('success', 'User updated');
            return $this->redirectToRoute('admin_users_index');
        }

        return $this->render('admin/user/edit.html.twig', [
            'form' => $form->createView(),
            'userEntity' => $user,
            'notifications' => $em->getRepository(PortalNotification::class)->findLatestForUser($this->getUser(), 5),
            'unreadNotificationsCount' => $em->getRepository(PortalNotification::class)->countUnreadForUser($this->getUser()),
        ]);
    }

    #[Route('/{id}/delete', name: 'admin_users_delete', methods: ['POST'])]
    public function delete(User $user, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->access->canEdit('users')) {
            throw $this->createAccessDeniedException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        // Magasin check
        if ($this->access->isMagasinOnly('users') && $user->getMagasin() !== $currentUser->getMagasin()) {
            throw $this->createAccessDeniedException('Vous ne pouvez suspendre que les utilisateurs de votre magasin.');
        }

        $targetRole = $user->getRoleEntity();
        if ($targetRole && !$this->canManageTargetRole($targetRole, $user)) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete_user_' . $user->getId(), $request->request->get('_token'))) {
            $user->setIsActive(false);
            
            // Notification
            $notif = new PortalNotification();
            $notif->setUser($user);
            $notif->setTitle('Compte Suspendu');
            $notif->setContent('Votre compte a été suspendu par l\'administration.');
            $notif->setType('ACCOUNT_SUSPENDED');
            $em->persist($notif);

            $em->flush();
            $this->addFlash('success', 'Le compte a été suspendu avec succès.');
        }

        return $this->redirectToRoute('admin_users_index');
    }

    #[Route('/{id}/activate', name: 'admin_users_activate', methods: ['POST'])]
    public function activate(User $user, Request $request, EntityManagerInterface $em): Response
    {
        if (!$this->access->canEdit('users')) {
            throw $this->createAccessDeniedException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        // Magasin check
        if ($this->access->isMagasinOnly('users') && $user->getMagasin() !== $currentUser->getMagasin()) {
            throw $this->createAccessDeniedException('Vous ne pouvez réactiver que les utilisateurs de votre magasin.');
        }

        if ($this->isCsrfTokenValid('activate_user_' . $user->getId(), $request->request->get('_token'))) {
            $user->setIsActive(true);
            
            // Notification
            $notif = new PortalNotification();
            $notif->setUser($user);
            $notif->setTitle('Compte Réactivé');
            $notif->setContent('Bonne nouvelle ! Votre compte a été réactivé.');
            $notif->setType('ACCOUNT_REACTIVATED');
            $em->persist($notif);

            $em->flush();
            $this->addFlash('success', 'Le compte a été réactivé avec succès.');
        }

        return $this->redirectToRoute('admin_users_index');
    }

    private function getAvailableRolesForPersonnel(EntityManagerInterface $em): array
    {
        return $em->getRepository(\App\Entity\Role::class)->findBy([], ['priority' => 'ASC']);
    }

    private function canManageTargetRole(\App\Entity\Role $targetRole, User $targetUser): bool
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $currentRole = $currentUser->getRoleEntity();

        if (!$currentRole) return false;

        // Higher role has LOWER priority number (e.g. 1 is higher than 10)
        // A user can manage users with a LOWER OR EQUAL role (LOWER role = HIGHER priority number)
        // We allow EQUAL priority so Directeurs can edit each other (but critical fields are locked in UserType)
        return $currentRole->getPriority() <= $targetRole->getPriority();
    }
}


