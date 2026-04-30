<?php

namespace App\Controller;

use App\Entity\ObservationMonthLock;
use App\Entity\UserObservation;
use App\Repository\ObservationMonthLockRepository;
use App\Repository\UserObservationRepository;
use App\Repository\UserRepository;
use App\Service\AccessHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user-observations')]
class UserObservationController extends AbstractController
{
    private AccessHelper $access;

    public function __construct(AccessHelper $access)
    {
        $this->access = $access;
    }

    #[Route('/', name: 'app_user_observations_index', methods: ['GET'])]
    public function index(Request $request, UserRepository $userRepo, UserObservationRepository $observationRepo): Response
    {
        // Check access - only ACCES_TOTAL and ADMIN_MAGASIN can access
        $level = $this->access->getAccessLevel('user_observations');
        if (!in_array($level, ['ACCES_TOTAL', 'ADMIN_MAGASIN'])) {
            throw $this->createAccessDeniedException();
        }

        /** @var \App\Entity\User $currentUser */
        $currentUser = $this->getUser();

        $magasinFilter = $request->query->get('magasin');
        $moisFilter = $request->query->get('mois');

        // Set current month as default if no filter provided
        if (!$moisFilter) {
            $moisFilter = (new \DateTime())->format('Y-m');
        }

        // Get all users with their observations
        $users = $userRepo->createQueryBuilder('u')
            ->where("u.magasin != 'Client'")
            ->andWhere('u.magasin IS NOT NULL');

        // If not ACCES_TOTAL, filter by current user's magasin
        if ($level !== 'ACCES_TOTAL') {
            $users->andWhere('u.magasin = :my_magasin')
                  ->setParameter('my_magasin', $currentUser->getMagasin());
        }

        if ($magasinFilter) {
            $users->andWhere('u.magasin = :magasin')
                  ->setParameter('magasin', $magasinFilter);
        }

        $users = $users->orderBy('u.magasin', 'ASC')
                       ->addOrderBy('u.nom', 'ASC')
                       ->getQuery()
                       ->getResult();

        // Get observations for each user
        $observationsData = [];
        foreach ($users as $user) {
            $observation = $observationRepo->findByUserAndMonth($user->getId(), $moisFilter);
            $observationsData[$user->getId()] = $observation;
        }

        // Get available magasins for filter
        $magasins = [];
        foreach ($users as $user) {
            $mag = $user->getMagasin();
            if ($mag && !in_array($mag, $magasins)) {
                $magasins[] = $mag;
            }
        }
        sort($magasins);

        return $this->render('user_observation/index.html.twig', [
            'users' => $users,
            'observationsData' => $observationsData,
            'magasins' => $magasins,
            'magasinFilter' => $magasinFilter,
            'moisFilter' => $moisFilter,
            'isFullAccess' => $level === 'ACCES_TOTAL',
        ]);
    }

    #[Route('/update', name: 'app_user_observations_update', methods: ['POST'])]
    public function update(Request $request, UserRepository $userRepo, UserObservationRepository $observationRepo, ObservationMonthLockRepository $lockRepo, EntityManagerInterface $em): JsonResponse
    {
        // Check access - only ACCES_TOTAL and ADMIN_MAGASIN can update
        $level = $this->access->getAccessLevel('user_observations');
        if (!in_array($level, ['ACCES_TOTAL', 'ADMIN_MAGASIN'])) {
            return new JsonResponse(['success' => false, 'error' => 'Access denied'], 403);
        }

        $userId = $request->request->get('user_id');
        $observation = $request->request->get('observation');
        $ticketRestaurant = $request->request->get('ticket_restaurant');
        $mois = $request->request->get('mois');
        
        // Convert empty string to null for mois
        $mois = $mois ?: null;

        // Check if month is locked
        if ($mois && $lockRepo->isMonthLocked($mois)) {
            return new JsonResponse(['success' => false, 'error' => 'Ce mois est verrouillé. Les modifications ne sont pas autorisées.'], 403);
        }

        if (!$userId) {
            return new JsonResponse(['success' => false, 'error' => 'User ID required'], 400);
        }

        $user = $userRepo->find($userId);
        if (!$user) {
            return new JsonResponse(['success' => false, 'error' => 'User not found'], 404);
        }

        // Check magasin access for ADMIN_MAGASIN
        if ($level === 'ADMIN_MAGASIN') {
            /** @var \App\Entity\User $currentUser */
            $currentUser = $this->getUser();
            if ($user->getMagasin() !== $currentUser->getMagasin()) {
                return new JsonResponse(['success' => false, 'error' => 'Access denied for this user'], 403);
            }
        }

        // Validate ticket restaurant
        if ($ticketRestaurant !== null && $ticketRestaurant !== '') {
            $ticketRestaurant = (int) $ticketRestaurant;
            if ($ticketRestaurant < 0 || $ticketRestaurant > 99) {
                return new JsonResponse(['success' => false, 'error' => 'Ticket Restaurant must be between 0 and 99'], 400);
            }
        } else {
            $ticketRestaurant = null;
        }

        // Find or create observation
        $userObservation = $observationRepo->findByUserAndMonth($userId, $mois);

        if (!$userObservation) {
            $userObservation = new UserObservation();
            $userObservation->setUser($user);
            $em->persist($userObservation);
        }

        // Always set the mois (in case it changed)
        $userObservation->setMois($mois);
        $userObservation->setObservation($observation ?: null);
        $userObservation->setTicketRestaurant($ticketRestaurant);
        $userObservation->setActive(true);

        $em->flush();

        return new JsonResponse([
            'success' => true,
            'message' => 'Observation updated successfully'
        ]);
    }

    #[Route('/delete/{id}', name: 'app_user_observations_delete', methods: ['POST'])]
    public function delete(Request $request, UserObservation $observation, EntityManagerInterface $em): JsonResponse
    {
        // Check access - only ACCES_TOTAL and ADMIN_MAGASIN can delete
        $level = $this->access->getAccessLevel('user_observations');
        if (!in_array($level, ['ACCES_TOTAL', 'ADMIN_MAGASIN'])) {
            return new JsonResponse(['success' => false, 'error' => 'Access denied'], 403);
        }

        // Check magasin access for ADMIN_MAGASIN
        if ($level === 'ADMIN_MAGASIN') {
            /** @var \App\Entity\User $currentUser */
            $currentUser = $this->getUser();
            if ($observation->getUser()->getMagasin() !== $currentUser->getMagasin()) {
                return new JsonResponse(['success' => false, 'error' => 'Access denied for this observation'], 403);
            }
        }

        $observation->setActive(false);
        $em->flush();

        return new JsonResponse([
            'success' => true,
            'message' => 'Observation deleted successfully'
        ]);
    }

    #[Route('/lock', name: 'app_user_observations_lock', methods: ['POST'])]
    public function toggleLock(Request $request, ObservationMonthLockRepository $lockRepo, EntityManagerInterface $em): JsonResponse
    {
        // Check access - ACCES_TOTAL and ADMIN_MAGASIN can lock/unlock
        $level = $this->access->getAccessLevel('user_observations');
        if (!in_array($level, ['ACCES_TOTAL', 'ADMIN_MAGASIN'])) {
            return new JsonResponse(['success' => false, 'error' => 'Access denied'], 403);
        }

        $mois = $request->request->get('mois');
        $isLocked = $request->request->get('is_locked') === '1';

        if (!$mois) {
            return new JsonResponse(['success' => false, 'error' => 'Month required'], 400);
        }

        $lock = $lockRepo->findByMois($mois);

        if (!$lock) {
            $lock = new ObservationMonthLock();
            $lock->setMois($mois);
            $em->persist($lock);
        }

        $lock->setIsLocked($isLocked);
        $lock->setLockedBy($this->getUser());
        $lock->setLockedAt($isLocked ? new \DateTime() : null);

        $em->flush();

        return new JsonResponse([
            'success' => true,
            'isLocked' => $isLocked,
            'message' => $isLocked ? 'Month locked successfully' : 'Month unlocked successfully'
        ]);
    }

    #[Route('/check-lock', name: 'app_user_observations_check_lock', methods: ['GET'])]
    public function checkLock(Request $request, ObservationMonthLockRepository $lockRepo): JsonResponse
    {
        $mois = $request->query->get('mois');

        if (!$mois) {
            return new JsonResponse(['success' => false, 'error' => 'Month required'], 400);
        }

        $isLocked = $lockRepo->isMonthLocked($mois);

        return new JsonResponse([
            'success' => true,
            'isLocked' => $isLocked
        ]);
    }
}
