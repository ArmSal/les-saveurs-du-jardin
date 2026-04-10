<?php

namespace App\Controller;

use App\Entity\PortalShortcut;
use App\Entity\Commande;
use App\Entity\User;
use App\Entity\PortalHoraire;
use App\Entity\PortalProduct;
use App\Entity\PortalNotification;
use App\Entity\PortalConge;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\AccessHelper;

class DashboardController extends AbstractController
{
    private AccessHelper $access;

    public function __construct(AccessHelper $access)
    {
        $this->access = $access;
    }

    #[Route('/dashboard', name: 'app_dashboard')]
    public function index(EntityManagerInterface $em): Response
    {
        if (!$this->access->canView('dashboard')) {
            throw $this->createAccessDeniedException();
        }

        // 1. Active Orders Count (Pending, Processing, Processed, Confirmed)
        $activeStatuses = [
            Commande::STATUS_PENDING,
            Commande::STATUS_PROCESSING,
            Commande::STATUS_PROCESSED,
            Commande::STATUS_CONFIRMED,
            Commande::STATUS_UPDATED
        ];

        $activeOrdersQb = $em->getRepository(Commande::class)->createQueryBuilder('c')
            ->select('count(c.id)')
            ->where('c.status IN (:statuses)')
            ->setParameter('statuses', $activeStatuses);

        if ($this->access->isMagasinOnly('dashboard')) {
            $activeOrdersQb->join('c.user', 'u')
                ->andWhere('u.magasin = :my_mag')
                ->setParameter('my_mag', $this->getUser()->getMagasin());
        }

        $activeOrdersCount = $activeOrdersQb->getQuery()->getSingleScalarResult();

        // 2. Total Revenue (Sum of all orders except canceled)
        $allOrdersQb = $em->getRepository(Commande::class)->createQueryBuilder('c')
            ->where('c.status != :canceled')
            ->setParameter('canceled', Commande::STATUS_CANCELED);

        if ($this->access->isMagasinOnly('dashboard')) {
            /** @var User $user */
            $user = $this->getUser();
            $allOrdersQb->join('c.user', 'u')
                ->andWhere('u.magasin = :my_mag')
                ->setParameter('my_mag', $user->getMagasin());
        }

        $allOrders = $allOrdersQb->getQuery()->getResult();

        $totalRevenue = 0;
        foreach ($allOrders as $order) {
            foreach ($order->getItems() as $item) {
                // Ensure getting price handles null
                if ($item->getProduct()) {
                    $totalRevenue += ($item->getQuantity() * (float) $item->getProduct()->getPrix());
                }
            }
        }

        // 3. Current Employees Working
        $now = new \DateTime();
        $currentHorairesQb = $em->getRepository(PortalHoraire::class)->createQueryBuilder('h')
            ->where('h.startTime <= :now')
            ->andWhere('h.endTime >= :now')
            ->setParameter('now', $now);

        if ($this->access->isMagasinOnly('dashboard')) {
            /** @var User $user */
            $user = $this->getUser();
            $currentHorairesQb->join('h.user', 'u')
                ->andWhere('u.magasin = :my_mag')
                ->setParameter('my_mag', $user->getMagasin());
        }

        $currentHoraires = $currentHorairesQb->getQuery()->getResult();

        $workingEmployees = [];
        $workingIds = [];
        foreach ($currentHoraires as $horaire) {
            $user = $horaire->getUser();
            if ($user && !isset($workingEmployees[$user->getId()])) {
                $workingEmployees[$user->getId()] = $user;
                $workingIds[] = $user->getId();
            }
        }
        $workingCount = count($workingEmployees);

        // 4. Total Users and Not Working
        $allUsersQb = $em->getRepository(User::class)->createQueryBuilder('u')
            ->where("u.magasin != 'Client' AND u.magasin IS NOT NULL");

        if ($this->access->isMagasinOnly('dashboard')) {
            /** @var User $user */
            $user = $this->getUser();
            $allUsersQb->andWhere('u.magasin = :my_mag')
                ->setParameter('my_mag', $user->getMagasin());
        }

        $allUsers = $allUsersQb->getQuery()->getResult();
        $totalUsersCount = count($allUsers);

        $notWorkingEmployees = [];
        foreach ($allUsers as $user) {
            if (!in_array($user->getId(), $workingIds)) {
                $notWorkingEmployees[] = $user;
            }
        }
        $notWorkingCount = count($notWorkingEmployees);

        // 5. Total Products
        $totalProducts = $em->getRepository(PortalProduct::class)->count([]);

        // 6. Recent Orders
        $recentOrdersQb = $em->getRepository(Commande::class)->createQueryBuilder('c')
            ->orderBy('c.createdAt', 'DESC')
            ->setMaxResults(5);

        if ($this->access->isMagasinOnly('dashboard')) {
            /** @var User $user */
            $user = $this->getUser();
            $recentOrdersQb->join('c.user', 'u')
                ->andWhere('u.magasin = :my_mag')
                ->setParameter('my_mag', $user->getMagasin());
        }

        $recentOrders = $recentOrdersQb->getQuery()->getResult();

        // 7. Get All Unique Magasins for Reports
        $magasins = $em->getRepository(User::class)->createQueryBuilder('u')
            ->select('DISTINCT u.magasin')
            ->where('u.magasin IS NOT NULL')
            ->andWhere("u.magasin != 'Client'")
            ->orderBy('u.magasin', 'ASC')
            ->getQuery()
            ->getResult();
        
        $magasinList = array_map(fn($m) => $m['magasin'], $magasins);

        $shortcuts = $em->getRepository(PortalShortcut::class)->findBy([], ['displayOrder' => 'ASC']);

        // 8. Upcoming Approved Congés (for dashboard card)
        $congeRepo = $em->getRepository(PortalConge::class);
        $today = new \DateTime();
        $upcomingApprovedQB = $congeRepo->createQueryBuilder('c')
            ->leftJoin('c.user', 'u')
            ->where('c.status = :status')
            ->andWhere('c.endDate >= :today')
            ->setParameter('status', 'APPROVED')
            ->setParameter('today', $today)
            ->orderBy('c.startDate', 'ASC');

        if ($this->access->isMagasinOnly('dashboard')) {
            $upcomingApprovedQB->andWhere('u.magasin = :my_mag')
                ->setParameter('my_mag', $this->getUser()->getMagasin());
        }

        $upcomingApproved = $upcomingApprovedQB->getQuery()->getResult();

        // 9. Generate Week List for Reports (Last 16 weeks)
        $weekList = [];
        $today = new \DateTime();

        for ($i = 0; $i < 16; $i++) {
            $iterDate = (clone $today)->modify("-" . ($i * 7) . " days");
            $w = \App\Service\CalendarHelper::getCustomWeekNumber($iterDate);
            $y = \App\Service\CalendarHelper::getCustomYearForWeek($iterDate);
            
            $start = (clone $iterDate)->modify('monday this week');
            $end = (clone $start)->modify('+6 days');
            
            $monthNames = [
                '1' => 'Jan', '2' => 'Fév', '3' => 'Mar', '4' => 'Avr', '5' => 'Mai', '6' => 'Juin',
                '7' => 'Juil', '8' => 'Août', '9' => 'Sept', '10' => 'Oct', '11' => 'Nov', '12' => 'Déc'
            ];
            
            $startDay = $start->format('j');
            $endDay = $end->format('j');
            $endMonth = $monthNames[$end->format('n')];
            
            $label = sprintf("Semaine %d (%d-%d %s)", $w, $startDay, $endDay, $endMonth);
            
            $weekList[] = [
                'week' => $w,
                'year' => $y,
                'label' => $label
            ];
        }

        return $this->render('dashboard/index.html.twig', [
            'activeOrdersCount' => $activeOrdersCount,
            'totalRevenue' => $totalRevenue,
            'totalUsers' => $totalUsersCount,
            'workingCount' => $workingCount,
            'workingEmployees' => array_values($workingEmployees),
            'notWorkingCount' => $notWorkingCount,
            'notWorkingEmployees' => $notWorkingEmployees,
            'totalProducts' => $totalProducts,
            'recentOrders' => $recentOrders,
            'magasins' => $magasinList,
            'employees' => $allUsers,
            'shortcuts' => $shortcuts,
            'weekList' => $weekList,
            'upcomingApproved' => $upcomingApproved,
        ]);
    }
}


