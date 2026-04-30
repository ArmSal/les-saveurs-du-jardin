<?php

namespace App\Controller;

use App\Entity\PortalHoraire;
use App\Entity\PortalMonthlyValidation;
use App\Entity\User;
use App\Repository\PortalHoraireRepository;
use App\Repository\PortalMonthlyValidationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\PortalConge;
use App\Entity\PortalNotification;
use App\Repository\PortalCongeRepository;
use App\Repository\PortalNotificationRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Service\AccessHelper;

use Knp\Component\Pager\PaginatorInterface;

class RHController extends AbstractController
{
    private AccessHelper $access;

    public function __construct(AccessHelper $access)
    {
        $this->access = $access;
    }

    #[Route('/rh/conge', name: 'app_rh_conge')]
    public function congeDashboard(
        PortalCongeRepository $congeRepo, 
        \App\Repository\UserRepository $userRepo, 
        PortalNotificationRepository $notifRepo,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        if (!$this->access->canView('rh_conge')) {
            throw $this->createAccessDeniedException();
        }
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        
        $canEdit = $this->access->canEdit('rh_conge');
        $isFullAccess = $this->access->isFullAccess('rh_conge');
        $isMagasinOnly = $this->access->isMagasinOnly('rh_conge');

        // Base Query for History
        $historyQuery = $congeRepo->createQueryBuilder('c')
            ->innerJoin('c.user', 'u')
            ->where('c.status IN (:historyStatus)')
            ->setParameter('historyStatus', ['APPROVED', 'REJECTED', 'CANCELLED'])
            ->orderBy('c.updatedAt', 'DESC');

        // Base Query for Pending (Manageable requests)
        $pendingQB = $congeRepo->createQueryBuilder('c')
            ->innerJoin('c.user', 'u')
            ->where('c.status IN (:pendingStatus)')
            ->setParameter('pendingStatus', ['PENDING', 'MODIFIED', 'ACCEPTED_BY_EMPLOYEE'])
            ->orderBy('c.createdAt', 'DESC');

        if ($canEdit) {
            if ($isMagasinOnly) {
                // Filter requests and history by the manager's magasin
                $userMagasin = $currentUser->getMagasin();
                $pendingQB->andWhere('u.magasin = :my_mag')->setParameter('my_mag', $userMagasin);
                $historyQuery->andWhere('u.magasin = :my_mag')->setParameter('my_mag', $userMagasin);
                
                // DEBUG: Log the query for ACCES MAGASIN users
                error_log(sprintf('[CONGE DEBUG] User: %s, Magasin: "%s", canEdit: %s, isMagasinOnly: %s', 
                    $currentUser->getPrenom() . ' ' . $currentUser->getNom(),
                    $userMagasin ?? 'NULL',
                    $canEdit ? 'true' : 'false',
                    $isMagasinOnly ? 'true' : 'false'
                ));
                
                // DEBUG: Show the actual SQL query
                $sql = $pendingQB->getQuery()->getSQL();
                $params = $pendingQB->getQuery()->getParameters();
                error_log(sprintf('[CONGE DEBUG] SQL: %s', $sql));
                error_log(sprintf('[CONGE DEBUG] Params: %s', json_encode($params->getKeys())));
            }
            
            $pending = $pendingQB->getQuery()->getResult();
            error_log(sprintf('[CONGE DEBUG] Pending count: %d', count($pending)));
            
            // Get all employees for calculating magasin stats
            $allEmployesQB = $userRepo->createQueryBuilder('u')
                ->where("u.magasin != 'Client' AND u.magasin IS NOT NULL")
                ->orderBy('u.nom', 'ASC');
            
            if ($isMagasinOnly) {
                $allEmployesQB->andWhere('u.magasin = :my_mag')->setParameter('my_mag', $currentUser->getMagasin());
            }
            $allEmployes = $allEmployesQB->getQuery()->getResult();
            
            // Get upcoming approved congés for stats and Validés section
            $today = new \DateTime();
            $upcomingApprovedQB = $congeRepo->createQueryBuilder('c')
                ->innerJoin('c.user', 'u')
                ->where('c.status = :status')
                ->andWhere('c.endDate >= :today')
                ->setParameter('status', 'APPROVED')
                ->setParameter('today', $today)
                ->orderBy('c.startDate', 'ASC');

            if ($isMagasinOnly) {
                $upcomingApprovedQB->andWhere('u.magasin = :my_mag')->setParameter('my_mag', $currentUser->getMagasin());
            }

            $upcomingApproved = $upcomingApprovedQB->getQuery()->getResult();

            // Calculate magasin stats: people on congé / total employees
            $magasinStats = [];
            $employesByMagasin = [];
            
            // Group employees by magasin
            foreach ($allEmployes as $emp) {
                $mag = $emp->getMagasin() ?: 'Non assigné';
                if (!isset($employesByMagasin[$mag])) {
                    $employesByMagasin[$mag] = [];
                }
                $employesByMagasin[$mag][] = $emp;
            }
            
            // For each magasin, count employees currently on congé
            foreach ($employesByMagasin as $mag => $emps) {
                $totalInMagasin = count($emps);
                $onCongeCount = 0;
                
                foreach ($upcomingApproved as $conge) {
                    if ($conge->getUser()->getMagasin() === $mag) {
                        $onCongeCount++;
                    }
                }
                
                $magasinStats[$mag] = [
                    'onConge' => $onCongeCount,
                    'total' => $totalInMagasin
                ];
            }

            if ($isMagasinOnly) {
                // For magasin-only access, they can only see their own magasin
                $magasins = [$currentUser->getMagasin()];
            } else {
                // For full access, list all magasins where we have employees
                $magasins = array_unique(array_filter(array_map(fn($u) => $u->getMagasin(), $allEmployes)));
                $magasins = array_filter($magasins, fn($m) => !preg_match('/client/i', $m));
                sort($magasins);
            }
            
            $employesQB = $userRepo->createQueryBuilder('u')
                ->where("u.magasin != 'Client' AND u.magasin IS NOT NULL")
                ->orderBy('u.nom', 'ASC');
            
            if ($isMagasinOnly) {
                $employesQB->andWhere('u.magasin = :my_mag')->setParameter('my_mag', $currentUser->getMagasin());
            }
            $employes = $employesQB->getQuery()->getResult();
        } else {
            // Normal Employee: See only personal requests
            $pending = $congeRepo->findBy(['user' => $currentUser, 'status' => ['PENDING', 'MODIFIED', 'ACCEPTED_BY_EMPLOYEE']], ['createdAt' => 'DESC']);
            $historyQuery->andWhere('c.user = :user')->setParameter('user', $currentUser);
            
            $upcomingApproved = $congeRepo->createQueryBuilder('c')
                ->where('c.user = :user')
                ->andWhere('c.status = :status')
                ->andWhere('c.endDate >= :today')
                ->setParameter('user', $currentUser)
                ->setParameter('status', 'APPROVED')
                ->setParameter('today', new \DateTime())
                ->orderBy('c.startDate', 'ASC')
                ->getQuery()
                ->getResult();
                
            $employes = [];
            $magasins = [];
        }

        $history = $paginator->paginate(
            $historyQuery,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('rh/conge.html.twig', [
            'pending' => $pending,
            'history' => $history,
            'upcomingApproved' => $upcomingApproved,
            'employes' => $employes,
            'magasins' => $magasins,
            'magasinStats' => $magasinStats ?? [],
            'canEdit' => $canEdit,
            'isFullAccess' => $isFullAccess,
            'isMagasinOnly' => $isMagasinOnly,
        ]);
    }

    #[Route('/rh/conge/ask', name: 'app_rh_conge_ask', methods: ['POST'])]
    public function askConge(Request $request, EntityManagerInterface $em): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        
        $start_str = $request->request->get('start_date');
        $end_str = $request->request->get('end_date');
        if (!$start_str || !$end_str) {
            $this->addFlash('error', 'Veuillez saisir les deux dates.');
            return $this->redirectToRoute('app_rh_conge');
        }
        $startDate = new \DateTime($start_str);
        $endDate = new \DateTime($end_str);

        if ($startDate > $endDate) {
            $this->addFlash('error', 'La date de fin ne peut pas être antérieure à la date de début.');
            return $this->redirectToRoute('app_rh_conge');
        }
        $type = $request->request->get('type');
        $comment = $request->request->get('comment');

        $conge = new PortalConge();
        $conge->setUser($currentUser);
        $conge->setStartDate($startDate);
        $conge->setEndDate($endDate);
        $conge->setType($type);
        $conge->setEmployeeComment($comment);
        $conge->setStatus('PENDING');
        
        // Simplified History
        $conge->setHistory([
            [
                'at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'who' => 'Employé',
                'action' => 'Demande initiale (' . $type . ')',
                'comment' => $comment,
                'dates' => $startDate->format('d/m/Y') . ' → ' . $endDate->format('d/m/Y')
            ]
        ]);

        $em->persist($conge);

        // Notification to users with edit access to this module
        $allUsers = $em->getRepository(User::class)->findAll();
        foreach ($allUsers as $manager) {
            if (!$this->access->canEdit('rh_conge', $manager)) {
                continue;
            }
            
            // Magasin restriction for the manager
            if ($this->access->isMagasinOnly('rh_conge', $manager) && $manager->getMagasin() !== $currentUser->getMagasin()) {
                continue;
            }

            $notif = new PortalNotification();
            $notif->setUser($manager);
            $notif->setTitle('Nouvelle Demande de Congé');
            $notif->setContent(sprintf('%s propose un congé (%s) du %s au %s.', 
                $currentUser->getPrenom(), 
                $type,
                $startDate->format('d/m/Y'), 
                $endDate->format('d/m/Y')
            ));
            $notif->setLink('/rh/conge');
            $notif->setType('CONGE_REQUEST');
            $em->persist($notif);
        }

        $em->flush();

        $this->addFlash('success', 'Votre demande de congé a été envoyée.');
        return $this->redirectToRoute('app_rh_conge');
    }

    #[Route('/rh/conge/admin-action/{id}', name: 'app_rh_conge_admin_action', methods: ['POST'])]
    public function adminCongeAction(PortalConge $conge, Request $request, EntityManagerInterface $em, PortalHoraireRepository $horaireRepo): Response
    {
        if (!$this->access->canEdit('rh_conge')) {
            throw $this->createAccessDeniedException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        // Magasin check
        if ($this->access->isMagasinOnly('rh_conge') && $conge->getUser()->getMagasin() !== $currentUser->getMagasin()) {
            throw $this->createAccessDeniedException('Vous ne pouvez gérer que les congés de votre magasin.');
        }

        // SECURITY: A user can NEVER approve their own request
        if ($conge->getUser() === $this->getUser()) {
            $this->addFlash('error', 'Auto-approbation interdite. Un autre responsable doit valider votre dossier.');
            return $this->redirectToRoute('app_rh_conge');
        }

        $action = $request->request->get('action'); // 'APPROVE', 'REJECT', 'MODIFY'
        $comment = $request->request->get('comment');
         // Potentially modified dates and type
        $newStartDate = $request->request->get('new_start_date');
        $newEndDate = $request->request->get('new_end_date');
        $newType = $request->request->get('new_type');
        
        $conge->setUpdatedAt(new \DateTime());
        
        if ($action === 'APPROVE') {
            // Validation des dates
            if ($newStartDate && $newEndDate) {
                if (new \DateTime($newStartDate) > new \DateTime($newEndDate)) {
                    $this->addFlash('error', 'La date de fin révisée ne peut pas être antérieure au début.');
                    return $this->redirectToRoute('app_rh_conge');
                }
            }

            // Mandatory signature for approval
            $signature = $request->request->get('signature');
            if (!$signature && ($conge->getStatus() === 'PENDING' || $conge->getStatus() === 'ACCEPTED_BY_EMPLOYEE')) {
                $this->addFlash('error', 'La signature est obligatoire pour approuver un congé.');
                return $this->redirectToRoute('app_rh_conge');
            }

            // Update with new data if provided
            if ($newType) $conge->setType($newType);
            if ($newStartDate) $conge->setStartDate(new \DateTime($newStartDate));
            if ($newEndDate) $conge->setEndDate(new \DateTime($newEndDate));

            $conge->setStatus('APPROVED');
            $conge->setAdminComment($comment);
            if ($signature) $conge->setApprovedSignature($signature);
            /** @var User $admin */
            $admin = $this->getUser();
            $conge->setApprovedAt(new \DateTime());
            $conge->setApprovedBy($admin->getPrenom() . ' ' . $admin->getNom());

            // History
            $history = $conge->getHistory();
            $history[] = [
                'at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'who' => 'Direction',
                'action' => 'Validation & Signature',
                'comment' => 'Dossier approuvé par ' . $admin->getPrenom() . ' ' . $admin->getNom() . '. ' . ($comment ? 'Note: ' . $comment : '')
            ];
            $conge->setHistory($history);

            // Check for overlap before creating the agenda entry
            $startAt = \DateTime::createFromInterface($conge->getStartDate())->setTime(0, 0, 0);
            $endAt = \DateTime::createFromInterface($conge->getEndDate())->setTime(0, 0, 0);
            
            if ($horaireRepo->checkOverlap($conge->getUser(), $startAt, $endAt)) {
                $this->addFlash('error', 'Impossible d\'approuver : cet employé a déjà un horaire ou un autre congé validé sur cette période.');
                return $this->redirectToRoute('app_rh_conge');
            }

            // Add to agenda as a single all-day entry
            $horaire = new PortalHoraire();
            $horaire->setUser($conge->getUser());
            $type = $conge->getType();
            $horaire->setStatus($type);
            
            // Set dynamic color based on type
            $color = '#6b7280'; // Default gray for 'Autre' or 'Sans Solde'
            if ($type === 'Congé Payé') {
                $color = '#10b981'; // Emerald
            } elseif ($type === 'Sans Solde') {
                $color = '#f59e0b'; // Amber
            }
            $horaire->setColor($color);

            $horaire->setStartTime($startAt);
            $horaire->setEndTime($endAt); // Inclusive storage
            $horaire->setNote('Validé via RH');
            $horaire->setLocked(true);
            $em->persist($horaire);

            // Notification
            $notif = new PortalNotification();
            $notif->setUser($conge->getUser());
            $notif->setTitle('Congé Approuvé');
            $notif->setContent(sprintf('Votre demande de congé du %s au %s a été approuvée.', $conge->getStartDate()->format('d/m/Y'), $conge->getEndDate()->format('d/m/Y')));
            $notif->setLink('/rh/conge');
            $notif->setType('CONGE_APPROVED');
            $em->persist($notif);

            $this->addFlash('success', 'Le congé a été approuvé et inscrit au planning.');

        } elseif ($action === 'MODIFY') {
            // Validation des dates
            if ($newStartDate && $newEndDate) {
                if (new \DateTime($newStartDate) > new \DateTime($newEndDate)) {
                    $this->addFlash('error', 'Les dates proposées sont invalides (Fin avant Début).');
                    return $this->redirectToRoute('app_rh_conge');
                }
            }
            // Update with proposed data
            if ($newType) $conge->setType($newType);
            if ($newStartDate) $conge->setStartDate(new \DateTime($newStartDate));
            if ($newEndDate) $conge->setEndDate(new \DateTime($newEndDate));

            $conge->setStatus('MODIFIED');
            $conge->setAdminComment($comment);

            // History
            $history = $conge->getHistory();
            $history[] = [
                'at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'who' => 'Direction',
                'action' => 'Proposition de modification',
                'comment' => 'Nouvelles dates proposées: ' . $conge->getStartDate()->format('d/m/Y') . ' → ' . $conge->getEndDate()->format('d/m/Y') . '. ' . ($comment ? 'Message: ' . $comment : '')
            ];
            $conge->setHistory($history);

            // Notification for employee
            $notif = new PortalNotification();
            $notif->setUser($conge->getUser());
            $notif->setTitle('Modification de congé proposée');
            $notif->setContent('La direction a proposé des modifications pour votre demande de congé. Merci de les valider ou refuser.');
            $notif->setLink('/rh/conge');
            $notif->setType('CONGE_INFO');
            $em->persist($notif);

            $this->addFlash('info', 'La proposition de modification a été envoyée à l\'employé.');

        } elseif ($action === 'REJECT') {
            $conge->setStatus('REJECTED');
            $conge->setAdminComment($comment);
            
            $history = $conge->getHistory();
            $history[] = [
                'at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'who' => 'Direction',
                'action' => 'Refus',
                'comment' => $comment
            ];
            $conge->setHistory($history);

            // Notification
            $notif = new PortalNotification();
            $notif->setUser($conge->getUser());
            $notif->setTitle('Congé Refusé');
            $notif->setContent(sprintf('Votre demande de congé du %s au %s a été refusée.', $conge->getStartDate()->format('d/m/Y'), $conge->getEndDate()->format('d/m/Y')));
            $notif->setLink('/rh/conge');
            $notif->setType('CONGE_REJECTED');
            $em->persist($notif);

            $this->addFlash('error', 'Le congé a été refusé.');

        } elseif ($action === 'DELETE') {
            // DELETE action: Delete the congé and associated horaire from agenda
            // This is only allowed for processed (archived) congés
            if (!in_array($conge->getStatus(), ['APPROVED', 'REJECTED', 'CANCELLED'])) {
                $this->addFlash('error', 'Impossible de supprimer un dossier en cours de traitement.');
                return $this->redirectToRoute('app_rh_conge');
            }

            // Find and delete associated horaire if it exists (for APPROVED congés)
            if ($conge->getStatus() === 'APPROVED') {
                $startAt = \DateTime::createFromInterface($conge->getStartDate())->setTime(0, 0, 0);
                $endAt = \DateTime::createFromInterface($conge->getEndDate())->setTime(0, 0, 0);

                $horaires = $horaireRepo->createQueryBuilder('h')
                    ->where('h.user = :user')
                    ->andWhere('h.startTime = :start')
                    ->andWhere('h.endTime = :end')
                    ->andWhere('h.note = :note')
                    ->setParameter('user', $conge->getUser())
                    ->setParameter('start', $startAt)
                    ->setParameter('end', $endAt)
                    ->setParameter('note', 'Validé via RH')
                    ->getQuery()
                    ->getResult();

                foreach ($horaires as $horaire) {
                    $em->remove($horaire);
                }
            }

            // Delete the congé
            $em->remove($conge);
            $this->addFlash('success', 'La demande de congé a été supprimée des archives.');
        }

        $em->flush();
        return $this->redirectToRoute('app_rh_conge');
    }

    #[Route('/rh/conge/employee-action/{id}', name: 'app_rh_conge_employee_action', methods: ['POST'])]
    public function employeeCongeAction(PortalConge $conge, Request $request, EntityManagerInterface $em, \App\Repository\UserRepository $userRepo): Response
    {
        $action = $request->request->get('action'); // 'ACCEPT', 'REJECT', 'CANCEL'
        $comment = $request->request->get('comment');
        
        $conge->setUpdatedAt(new \DateTime());

        // Cancellation is allowed for anyone until the request is closed (APPROVED/REJECTED)
        if ($action === 'CANCEL') {
            if (in_array($conge->getStatus(), ['APPROVED', 'REJECTED'])) {
                $this->addFlash('error', 'Impossible d\'annuler un dossier déjà clôturé.');
                return $this->redirectToRoute('app_rh_conge');
            }
            $conge->setStatus('CANCELLED');
            $history = $conge->getHistory();
            $history[] = [
                'at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'who' => 'Employé',
                'action' => 'Annulation',
                'comment' => $comment ?: 'L\'employé a annulé sa demande de repos.'
            ];
            $conge->setHistory($history);
            $this->addFlash('info', 'Votre demande de repos a été annulée.');
        } elseif ($action === 'MODIFY') {
            $newStartDate = $request->request->get('new_start_date');
            $newEndDate = $request->request->get('new_end_date');
            $newType = $request->request->get('new_type');

            if ($newStartDate && $newEndDate) {
                if (new \DateTime($newStartDate) > new \DateTime($newEndDate)) {
                    $this->addFlash('error', 'Dates invalides (fin avant début).');
                    return $this->redirectToRoute('app_rh_conge');
                }
                $conge->setStartDate(new \DateTime($newStartDate));
                $conge->setEndDate(new \DateTime($newEndDate));
            }
            if ($newType) $conge->setType($newType);

            $conge->setStatus('PENDING'); // Repasse en attente manager
            $history = $conge->getHistory();
            $history[] = [
                'at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'who' => 'Employé',
                'action' => 'Modification de la demande',
                'comment' => $comment ?: 'L\'employé a ajusté ses dates/nature de repos.',
                'dates' => ($conge->getStartDate() ? $conge->getStartDate()->format('d/m/Y') : '?') . ' → ' . ($conge->getEndDate() ? $conge->getEndDate()->format('d/m/Y') : '?')
            ];
            $conge->setHistory($history);
            $this->addFlash('success', 'Votre demande a été mise à jour et renvoyée pour arbitrage.');
        } elseif ($action === 'ACCEPT') {
            $conge->setStatus('ACCEPTED_BY_EMPLOYEE');
            $history = $conge->getHistory();
            $history[] = [
                'at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'who' => 'Employé',
                'action' => 'Acceptation',
                'comment' => $comment ?: 'L\'employé a accepté les modifications.'
            ];
            $conge->setHistory($history);

            // Notify Managers (anyone with edit access to rh_conge)
            $allUsers = $userRepo->findAll();
            foreach ($allUsers as $manager) {
                if (!$this->access->canEdit('rh_conge', $manager)) {
                    continue;
                }
                
                // Magasin restriction for the manager
                if ($this->access->isMagasinOnly('rh_conge', $manager) && $manager->getMagasin() !== $conge->getUser()->getMagasin()) {
                    continue;
                }

                $notif = new PortalNotification();
                $notif->setUser($manager);
                $notif->setTitle('Modification de congé acceptée');
                $notif->setContent($conge->getUser()->getPrenom() . ' a accepté vos modifications. Vous pouvez maintenant signer le dossier.');
                $notif->setLink('/rh/conge');
                $notif->setType('CONGE_INFO');
                $em->persist($notif);
            }

            $this->addFlash('success', 'Vous avez accepté les modifications. La direction va maintenant signer définitivement votre congé.');
        } else { // REJECT
            $conge->setStatus('REJECTED');
            $history = $conge->getHistory();
            $history[] = [
                'at' => (new \DateTime())->format('Y-m-d H:i:s'),
                'who' => 'Employé',
                'action' => 'Refus des modifications',
                'comment' => $comment ?: 'L\'employé a refusé les modifications proposées.'
            ];
            $conge->setHistory($history);
            $this->addFlash('error', 'Vous avez refusé les modifications. Le dossier est clos.');
        }

        $em->flush();
        return $this->redirectToRoute('app_rh_conge');
    }

    #[Route('/rh/report/check', name: 'app_rh_report_check', methods: ['POST'])]
    public function checkReport(Request $request, PortalHoraireRepository $horaireRepo, PortalMonthlyValidationRepository $validationRepo, \App\Repository\UserRepository $userRepo, AccessHelper $access): JsonResponse
    {
        if (!$access->canEdit('rh_validation')) {
            return new JsonResponse(['error' => 'Accès refusé'], 403);
        }

        $data = json_decode($request->getContent(), true);
        $month = $data['month'] ?? (int)date('m');
        $year = $data['year'] ?? (int)date('Y');
        $magasin = $data['magasin'] ?? null;
        $userId = $data['user_id'] ?? null;

        $startDate = new \DateTime($year . '-' . $month . '-01 00:00:00');
        $endDate = (clone $startDate)->modify('last day of this month')->setTime(23, 59, 59);

        // Fetch users in scope
        $qb = $userRepo->createQueryBuilder('u')
            ->where("u.magasin != 'Client' AND u.magasin IS NOT NULL");
        
        if ($access->isMagasinOnly('rh_validation')) {
            /** @var User $me */
            $me = $this->getUser();
            $qb->andWhere('u.magasin = :my_mag')
               ->setParameter('my_mag', $me->getMagasin());
        } elseif ($userId) {
            $qb->andWhere('u.id = :uid')->setParameter('uid', $userId);
        } elseif ($magasin && $magasin !== 'all') {
            $qb->andWhere('u.magasin = :mag')->setParameter('mag', $magasin);
        }
        $usersInScope = $qb->getQuery()->getResult();

        // Get those who have hours
        $userIdsWithHours = $horaireRepo->createQueryBuilder('h')
            ->select('DISTINCT IDENTITY(h.user)')
            ->where('h.startTime <= :end')
            ->andWhere('h.endTime >= :start')
            ->setParameter('start', $startDate)
            ->setParameter('end', $endDate)
            ->getQuery()
            ->getScalarResult();
        $userIdsWithHours = array_column($userIdsWithHours, 1);

        // Get those who signed
        $allValidations = $validationRepo->findBy(['month' => $month, 'year' => $year]);
        $signedUserIds = array_map(fn($v) => $v->getUser()->getId(), $allValidations);

        $missing = [];
        foreach ($usersInScope as $user) {
            if (in_array($user->getId(), $userIdsWithHours) && !in_array($user->getId(), $signedUserIds)) {
                $missing[] = $user->getPrenom() . ' ' . $user->getNom();
            }
        }

        return new JsonResponse([
            'success' => empty($missing),
            'missing' => $missing
        ]);
    }

    #[Route('/rh/report/generate', name: 'app_rh_report_generate')]
    public function generateReport(Request $request, PortalHoraireRepository $horaireRepo, PortalMonthlyValidationRepository $validationRepo, \App\Repository\UserRepository $userRepo, AccessHelper $access): Response
    {
        if (!($access->canEdit('rh_validation') || $access->isFullView('rh_validation') || $access->isMagasinOnly('rh_validation'))) {
            throw $this->createAccessDeniedException();
        }

        $month = $request->query->getInt('month');
        $year = $request->query->getInt('year');
        $magasin = $request->query->get('magasin');
        $userId = $request->query->get('user_id');

        $startDate = new \DateTime($year . '-' . $month . '-01 00:00:00');
        $endDate = (clone $startDate)->modify('last day of this month')->setTime(23, 59, 59);

        $qb = $userRepo->createQueryBuilder('u')
            ->where("u.magasin != 'Client' AND u.magasin IS NOT NULL");
        
        if ($access->isMagasinOnly('rh_validation')) {
            /** @var User $me */
            $me = $this->getUser();
            $qb->andWhere('u.magasin = :my_mag')
               ->setParameter('my_mag', $me->getMagasin());
        } elseif ($userId) {
            $qb->andWhere('u.id = :uid')->setParameter('uid', $userId);
        } elseif ($magasin && $magasin !== 'all') {
            $qb->andWhere('u.magasin = :mag')->setParameter('mag', $magasin);
        }
        $users = $qb->getQuery()->getResult();

        $validations = $validationRepo->createQueryBuilder('v')
            ->where('v.month = :month')
            ->andWhere('v.year = :year')
            ->andWhere('v.user IN (:users)')
            ->setParameter('month', $month)
            ->setParameter('year', $year)
            ->setParameter('users', $users)
            ->getQuery()
            ->getResult();

        $reportData = [];
        foreach ($validations as $v) {
            $u = $v->getUser();
            $hByDay = $horaireRepo->createQueryBuilder('h')
                ->where('h.user = :u')
                ->andWhere('h.startTime <= :e')
                ->andWhere('h.endTime >= :s')
                ->setParameter('u', $u)
                ->setParameter('s', $startDate)
                ->setParameter('e', $endDate)
                ->getQuery()
                ->getResult();
            
            $daysMap = $this->buildDaysMapForMonth($startDate, $hByDay);

            $reportData[] = [
                'validation' => $v,
                'daysMap' => $daysMap
            ];
        }

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $logoPath = $this->getParameter('kernel.project_dir') . '/public/logo.svg';
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $html = $this->renderView('rh/report_pdf.html.twig', [
            'reportData' => $reportData,
            'logoBase64' => $logoBase64,
            'month' => $month,
            'year' => $year,
            'startDate' => $startDate,
            'endDate' => $endDate,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $filename = sprintf('Rapport_RH_M%d_%d.pdf', $month, $year);
        return new Response($dompdf->output(), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"'
        ]);
    }

    #[Route('/rh/valider-mes-heures', name: 'app_rh_validation')]
    public function validateHours(Request $request, PortalHoraireRepository $horaireRepo, PortalMonthlyValidationRepository $validationRepo, \App\Repository\UserRepository $userRepo, EntityManagerInterface $em, AccessHelper $access): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        
        $month = $request->query->getInt('month', (int)date('m'));
        $year = $request->query->getInt('year', (int)date('Y'));
        $targetUserId = $request->query->get('user_id');
        $selectedMagasin = $request->query->get('magasin');

        if (!$access->canView('rh_validation')) {
            throw $this->createAccessDeniedException();
        }

        $targetUser = $currentUser;
        if ($targetUserId && ($access->canEdit('rh_validation') || $access->isFullView('rh_validation') || $access->isMagasinOnly('rh_validation'))) {
            $targetUser = $userRepo->find($targetUserId) ?: $currentUser;
            
            // Magasin check for managers
            if ($access->isMagasinOnly('rh_validation') && $targetUser->getMagasin() !== $currentUser->getMagasin()) {
                throw $this->createAccessDeniedException('Vous ne pouvez valider que les horaires des employés de votre magasin.');
            }
        } else {
            // Force personal view for non-managers
            $targetUser = $currentUser;
        }

        // Default to current user's ID if no user_id provided
        if (!$targetUserId) {
            $targetUserId = $currentUser->getId();
        }

        // Calculate start and end of month
        $startOfMonth = new \DateTime($year . '-' . $month . '-01 00:00:00');
        $endOfMonth = (clone $startOfMonth)->modify('last day of this month')->setTime(23, 59, 59);

        $horaires = $horaireRepo->createQueryBuilder('h')
            ->where('h.user = :user')
            ->andWhere('h.startTime <= :end')
            ->andWhere('h.endTime >= :start')
            ->setParameter('user', $targetUser)
            ->setParameter('start', $startOfMonth)
            ->setParameter('end', $endOfMonth)
            ->orderBy('h.startTime', 'ASC')
            ->getQuery()
            ->getResult();

        $daysMap = $this->buildDaysMapForMonth($startOfMonth, $horaires);

        $validation = $validationRepo->findOneBy([
            'user' => $targetUser,
            'month' => $month,
            'year' => $year
        ]);

        $signableStatus = $this->isMonthSignable($month, $year, $validation);

        $employes = [];
        $allMagasins = [];
        $dashboardData = [
            'missing' => [],
            'signed' => [],
            'is_urgent' => false
        ];

        if ($access->canEdit('rh_validation')) {
            $allEmployesQb = $userRepo->createQueryBuilder('u')
                ->where("u.magasin != 'Client' AND u.magasin IS NOT NULL")
                ->orderBy('u.nom', 'ASC');

            if ($access->isMagasinOnly('rh_validation')) {
                $allEmployesQb->andWhere('u.magasin = :my_mag')
                   ->setParameter('my_mag', $currentUser->getMagasin());
            }

            $allEmployes = $allEmployesQb->getQuery()->getResult();
            
            // Get unique magasins
            foreach ($allEmployes as $emp) {
                if ($emp->getMagasin() && !in_array($emp->getMagasin(), $allMagasins)) {
                    $allMagasins[] = $emp->getMagasin();
                }
            }
            sort($allMagasins);

            // Filter employes list by magasin if selected
            if ($selectedMagasin && $selectedMagasin !== 'all') {
                $employes = array_filter($allEmployes, fn($u) => $u->getMagasin() === $selectedMagasin);
            } else {
                $employes = $allEmployes;
            }
            
            // Get all validations for this month
            $allValidations = $validationRepo->findBy(['month' => $month, 'year' => $year]);
            $signedUserIds = array_map(fn($v) => $v->getUser()->getId(), $allValidations);

            // Get all user IDs who have hours this month
            $userIdsWithHours = $horaireRepo->createQueryBuilder('h')
                ->select('DISTINCT IDENTITY(h.user)')
                ->where('h.startTime >= :start')
                ->andWhere('h.startTime <= :end')
                ->setParameter('start', $startOfMonth)
                ->setParameter('end', $endOfMonth)
                ->getQuery()
                ->getScalarResult();
            $userIdsWithHours = array_column($userIdsWithHours, 1);

            $validationsByUser = [];
            foreach ($allValidations as $v) {
                $validationsByUser[$v->getUser()->getId()] = $v;
            }

            foreach ($allEmployes as $emp) {
                // Anyone with Full Access to this module is treated as an admin/directeur
                // and is therefore excluded from the list of people to be validated.
                if ($access->isFullAccess('rh_validation', $emp)) {
                    continue;
                }

                $hasHours = in_array($emp->getId(), $userIdsWithHours);
                $isSigned = isset($validationsByUser[$emp->getId()]) && $validationsByUser[$emp->getId()]->getSignature();
                $isUnlocked = isset($validationsByUser[$emp->getId()]) && $validationsByUser[$emp->getId()]->isUnlocked();
                
                if ($hasHours) {
                    $mag = $emp->getMagasin() ?: 'Inconnu';
                    
                    // Filter dashboard grouping by magasin if selected
                    if ($selectedMagasin && $selectedMagasin !== 'all' && $mag !== $selectedMagasin) {
                        continue;
                    }

                    // Note: We no longer filter dashboard by targetUserId here
                    // The dashboard should always show all users for managers
                    // The targetUserId only affects which hours are displayed

                    if ($isSigned) {
                        if (!isset($dashboardData['signed'][$mag])) $dashboardData['signed'][$mag] = [];
                        $dashboardData['signed'][$mag][] = [
                            'user' => $emp,
                            'validation' => $validationsByUser[$emp->getId()]
                        ];
                    } else {
                        if (!isset($dashboardData['missing'][$mag])) $dashboardData['missing'][$mag] = [];
                        $dashboardData['missing'][$mag][] = [
                            'user' => $emp,
                            'unlocked' => $isUnlocked
                        ];
                    }
                }
            }

            // Check if it's past month end
            $now = new \DateTime();
            if ($now > $endOfMonth || $now->format('m') > $month || $now->format('Y') > $year) {
                $dashboardData['is_urgent'] = true;
            }
        }

        $monthName = \IntlDateFormatter::formatObject($startOfMonth, 'MMMM', 'fr');

        return $this->render('rh/validation.html.twig', [
            'daysMap' => $daysMap,
            'month' => $month,
            'monthName' => $monthName,
            'year' => $year,
            'validation' => $validation,
            'startOfMonth' => $startOfMonth,
            'endOfMonth' => $endOfMonth,
            'targetUser' => $targetUser,
            'employes' => $employes,
            'allMagasins' => $allMagasins,
            'selectedMagasin' => $selectedMagasin,
            'targetUserId' => $targetUserId,
            'canEdit' => $access->canEdit('rh_validation'),
            'isFullAccess' => $access->isFullAccess('rh_validation'),
            'isMagasinOnly' => $access->isMagasinOnly('rh_validation'),
            'dashboard' => $dashboardData,
            'signableStatus' => $signableStatus,
        ]);
    }

    private function isMonthSignable(int $month, int $year, ?PortalMonthlyValidation $validation = null): array
    {
        if ($validation && $validation->isUnlocked()) {
            return ['signable' => true];
        }

        $now = new \DateTime();
        
        $lastDayOfMonth = new \DateTime($year . '-' . $month . '-01');
        $lastDayOfMonth->modify('last day of this month');
        $lastDayOfMonth->setTime(23, 0, 0);

        $firstDayOfMonth = new \DateTime($year . '-' . $month . '-01 00:00:00');

        $currentFirstDay = new \DateTime('first day of this month 00:00:00');

        // 1. Future months
        if ($firstDayOfMonth > $currentFirstDay) {
            return ['signable' => false, 'reason' => 'Ce mois est dans le futur.'];
        }

        // 2. Current month
        if ($firstDayOfMonth->format('Y-m') === $currentFirstDay->format('Y-m')) {
            if ($now < $lastDayOfMonth) {
                return ['signable' => false, 'reason' => 'La signature sera disponible le dernier jour du mois à partir de 23:00.'];
            }
        }

        return ['signable' => true];
    }

    #[Route('/rh/validation/toggle-unlock', name: 'app_rh_validation_unlock', methods: ['POST'])]
    public function toggleUnlockSignature(Request $request, \App\Repository\UserRepository $userRepo, PortalMonthlyValidationRepository $validationRepo, EntityManagerInterface $em, AccessHelper $access): JsonResponse
    {
        if (!$access->canEdit('rh_validation')) {
            return new JsonResponse(['error' => 'Accès refusé'], 403);
        }

        $data = json_decode($request->getContent(), true);
        $userId = $data['user_id'] ?? $request->request->get('userId');
        $month = $data['month'] ?? $request->request->get('month');
        $year = $data['year'] ?? $request->request->get('year');

        if (!$userId || !$month || !$year) {
            return new JsonResponse(['error' => 'Paramètres manquants'], 400);
        }

        $user = $userRepo->find($userId);
        if (!$user) return new JsonResponse(['error' => 'Utilisateur non trouvé'], 404);

        $validation = $validationRepo->findOneBy(['user' => $user, 'month' => $month, 'year' => $year]);
        
        if (!$validation) {
            $validation = new PortalMonthlyValidation();
            $validation->setUser($user);
            $validation->setMonth($month);
            $validation->setYear($year);
            $validation->setPdfName('temp'); // Placeholder
            $validation->setSignedAt(new \DateTime()); // Placeholder
        }

        $validation->setIsUnlocked(!$validation->isUnlocked());
        $em->persist($validation);
        $em->flush();

        return new JsonResponse(['success' => true, 'unlocked' => $validation->isUnlocked()]);
    }

    #[Route('/rh/valider-mes-heures/sign', name: 'app_rh_validation_sign', methods: ['POST'])]
    public function signHours(Request $request, PortalHoraireRepository $horaireRepo, PortalMonthlyValidationRepository $validationRepo, EntityManagerInterface $em, \App\Repository\UserRepository $userRepo, AccessHelper $access): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        
        $month = $request->request->getInt('month');
        $year = $request->request->getInt('year');
        $signature = $request->request->get('signature');
        $targetUserId = $request->request->get('user_id');

        // Determine who we're signing for
        $targetUser = $currentUser;
        if ($targetUserId && $targetUserId != $currentUser->getId()) {
            // Users can ONLY sign their own hours - prevent signing for others via form manipulation
            $this->addFlash('error', 'Vous ne pouvez signer que vos propres horaires.');
            return $this->redirectToRoute('app_rh_validation', ['month' => $month, 'year' => $year]);
        }

        $validation = $validationRepo->findOneBy([
            'user' => $targetUser,
            'month' => $month,
            'year' => $year
        ]);

        $signableStatus = $this->isMonthSignable($month, $year, $validation);
        if (!$signableStatus['signable']) {
            $this->addFlash('error', $signableStatus['reason']);
            return $this->redirectToRoute('app_rh_validation', ['month' => $month, 'year' => $year]);
        }

        if (!$signature) {
            $this->addFlash('error', 'La signature est requise.');
            return $this->redirectToRoute('app_rh_validation', ['month' => $month, 'year' => $year]);
        }

        // Check if already signed
        if ($validation && $validation->getSignature()) {
            $this->addFlash('error', 'Ce mois a déjà été validé.');
            return $this->redirectToRoute('app_rh_validation', ['month' => $month, 'year' => $year]);
        }

        // Fetch hours to lock them
        $startOfMonth = new \DateTime($year . '-' . $month . '-01 00:00:00');
        $endOfMonth = (clone $startOfMonth)->modify('last day of this month')->setTime(23, 59, 59);

        $horaires = $horaireRepo->createQueryBuilder('h')
            ->where('h.user = :user')
            ->andWhere('h.startTime <= :end')
            ->andWhere('h.endTime >= :start')
            ->setParameter('user', $targetUser)
            ->setParameter('start', $startOfMonth)
            ->setParameter('end', $endOfMonth)
            ->getQuery()
            ->getResult();

        foreach ($horaires as $horaire) {
            /** @var PortalHoraire $horaire */
            $horaire->setLocked(true);
        }

        $fullName = ucfirst(strtolower($targetUser->getPrenom())) . strtoupper($targetUser->getNom());
        $pdfName = sprintf('%s_moins%02d.pdf', 
            $fullName,
            $month
        );

        if (!$validation) {
            $validation = new PortalMonthlyValidation();
            $validation->setUser($targetUser);
            $validation->setMonth($month);
            $validation->setYear($year);
        }
        
        $validation->setSignature($signature);
        $validation->setSignedAt(new \DateTime());
        $validation->setPdfName($pdfName);

        $em->persist($validation);

        // Notification to Managers and Admins
        $allUsers = $userRepo->findAll();
        foreach ($allUsers as $adminInRange) {
            // Check if this user can manage RH validation
            if ($access->canEdit('rh_validation', $adminInRange)) {
                // If the manager is MagasinOnly, only notify if same magasin as employee
                if ($access->isMagasinOnly('rh_validation', $adminInRange) && $adminInRange->getMagasin() !== $targetUser->getMagasin()) {
                    continue;
                }
                
                $notif = new PortalNotification();
                $notif->setUser($adminInRange);
                $notif->setTitle('Signature Mensuelle');
                $notif->setContent(sprintf('%s a signé ses horaires pour le mois %d.', $targetUser->getPrenom(), $month));
                $notif->setLink('/rh/valider-mes-heures?month=' . $month . '&year=' . $year . '&user_id=' . $targetUser->getId());
                $notif->setType('MONTHLY_SIGNATURE');
                $em->persist($notif);
            }
        }

        $em->flush();

        // Generate PDF
        $this->generatePdf($validation, $horaires);

        $this->addFlash('success', 'Vos horaires ont été validés et signés avec succès.');
        return $this->redirectToRoute('app_rh_validation', ['month' => $month, 'year' => $year]);
    }

    #[Route('/notifications/mark-as-read', name: 'app_notifications_mark_read', methods: ['POST'])]
    public function markNotificationsRead(PortalNotificationRepository $notifRepo, EntityManagerInterface $em): JsonResponse
    {
        /** @var User $user */
        $user = $this->getUser();
        $unread = $notifRepo->findBy(['user' => $user, 'isRead' => false]);
        
        foreach ($unread as $n) {
            $n->setRead(true);
        }
        
        $em->flush();
        
        return new JsonResponse(['success' => true]);
    }

    #[Route('/rh/validation/reset', name: 'app_rh_validation_reset', methods: ['POST'])]
    public function resetValidationSignature(Request $request, \App\Repository\UserRepository $userRepo, PortalMonthlyValidationRepository $validationRepo, PortalHoraireRepository $horaireRepo, EntityManagerInterface $em, AccessHelper $access): JsonResponse
    {
        if (!$access->canEdit('rh_validation')) {
            return new JsonResponse(['error' => 'Accès refusé'], 403);
        }

        $data = json_decode($request->getContent(), true);
        $userId = $data['user_id'] ?? $request->request->get('userId');
        $month = $data['month'] ?? $request->request->get('month');
        $year = $data['year'] ?? $request->request->get('year');

        if (!$userId || !$month || !$year) {
            return new JsonResponse(['error' => 'Paramètres manquants'], 400);
        }

        $employee = $userRepo->find($userId);
        if (!$employee) return new JsonResponse(['error' => 'Employé non trouvé'], 404);

        $validation = $validationRepo->findOneBy(['user' => $employee, 'month' => $month, 'year' => $year]);
        
        if ($validation) {
            // Delete PDF if exists
            $pdfName = $validation->getPdfName();
            if ($pdfName && $pdfName !== 'temp') {
                $magasin = $employee->getMagasin() ?: 'Inconnu';
                $fullName = ucfirst(strtolower($employee->getPrenom())) . strtoupper($employee->getNom());
                $filePath = sprintf('%s/storage/heure_validations/%d/%s/%s/%s', 
                    $this->getParameter('kernel.project_dir'),
                    $year,
                    str_replace(['/', '\\'], '_', $magasin),
                    str_replace(['/', '\\'], '_', $fullName),
                    $pdfName
                );
                if (file_exists($filePath)) @unlink($filePath);
            }

            // Unlock hours
            $startOfMonth = new \DateTime($year . '-' . $month . '-01 00:00:00');
            $endOfMonth = (clone $startOfMonth)->modify('last day of this month')->setTime(23, 59, 59);
            $horaires = $horaireRepo->createQueryBuilder('h')
                ->where('h.user = :user')
                ->andWhere('h.startTime <= :end')
                ->andWhere('h.endTime >= :start')
                ->setParameter('user', $employee)
                ->setParameter('start', $startOfMonth)
                ->setParameter('end', $endOfMonth)
                ->getQuery()
                ->getResult();

            foreach ($horaires as $horaire) {
                /** @var PortalHoraire $horaire */
                $horaire->setLocked(false);
            }

            $em->remove($validation);
            $em->flush();
        }

        return new JsonResponse(['success' => true]);
    }

    #[Route('/rh/validation/api/hours', name: 'app_rh_validation_api_hours', methods: ['GET'])]
    public function getEmployeeHoursApi(Request $request, \App\Repository\UserRepository $userRepo, PortalHoraireRepository $horaireRepo, PortalMonthlyValidationRepository $validationRepo, AccessHelper $access): JsonResponse
    {
        if (!($access->canView('rh_validation') || $access->canEdit('rh_validation') || $access->isFullView('rh_validation'))) {
            return new JsonResponse(['error' => 'Accès refusé'], 403);
        }

        $userId = $request->query->getInt('user_id');
        $month = $request->query->getInt('month', (int)date('m'));
        $year = $request->query->getInt('year', (int)date('Y'));

        if (!$userId) {
            return new JsonResponse(['error' => 'User ID required'], 400);
        }

        $user = $userRepo->find($userId);
        if (!$user) {
            return new JsonResponse(['error' => 'Employé non trouvé'], 404);
        }

        // Security check
        $currentUser = $this->getUser();
        if ($access->isMagasinOnly('rh_validation') && $user->getMagasin() !== $currentUser->getMagasin()) {
            return new JsonResponse(['error' => 'Accès refusé'], 403);
        }

        // Get hours
        $startOfMonth = new \DateTime($year . '-' . $month . '-01 00:00:00');
        $endOfMonth = (clone $startOfMonth)->modify('last day of this month')->setTime(23, 59, 59);

        $horaires = $horaireRepo->createQueryBuilder('h')
            ->where('h.user = :user')
            ->andWhere('h.startTime <= :end')
            ->andWhere('h.endTime >= :start')
            ->setParameter('user', $user)
            ->setParameter('start', $startOfMonth)
            ->setParameter('end', $endOfMonth)
            ->orderBy('h.startTime', 'ASC')
            ->getQuery()
            ->getResult();

        // Build days map
        $daysMap = $this->buildDaysMapForMonth($startOfMonth, $horaires);

        // Format for JSON
        $formattedDays = [];
        $total_seconds = 0;
        foreach ($daysMap as $dateKey => $dayData) {
            $day_total_seconds = 0;
            $horairesList = [];
            
            foreach ($dayData['horaires'] as $h) {
                $is_actif = ($h->getStatus() === 'Actif' || !$h->getStatus());
                $diff_seconds = $h->getEndTime()->getTimestamp() - $h->getStartTime()->getTimestamp();
                
                if ($is_actif) {
                    $total_seconds += $diff_seconds;
                    $day_total_seconds += $diff_seconds;
                }
                
                $horairesList[] = [
                    'start' => $h->getStartTime()->format('H:i'),
                    'end' => $h->getEndTime()->format('H:i'),
                    'status' => $h->getStatus() ?: 'Actif',
                    'isActif' => $is_actif
                ];
            }
            
            $formattedDays[] = [
                'date' => $dayData['date']->format('Y-m-d'),
                'dayName' => $dayData['date']->format('D'),
                'dayNumber' => $dayData['date']->format('d/m/Y'),
                'horaires' => $horairesList,
                'dayTotalSeconds' => $day_total_seconds
            ];
        }

        // Check validation status
        $validation = $validationRepo->findOneBy(['user' => $user, 'month' => $month, 'year' => $year]);
        $isSigned = $validation && $validation->getSignature();

        return new JsonResponse([
            'user' => [
                'id' => $user->getId(),
                'prenom' => $user->getPrenom(),
                'nom' => $user->getNom(),
                'photo' => $user->getPhoto()
            ],
            'days' => $formattedDays,
            'totalSeconds' => $total_seconds,
            'isSigned' => $isSigned,
            'isCurrentUser' => $user->getId() === $currentUser->getId()
        ]);
    }

    #[Route('/rh/validation/remind', name: 'app_rh_validation_remind', methods: ['POST'])]
    public function remindEmployeeSignature(Request $request, \App\Repository\UserRepository $userRepo, EntityManagerInterface $em, AccessHelper $access): JsonResponse
    {
        if (!$access->canEdit('rh_validation')) {
            return new JsonResponse(['error' => 'Accès refusé'], 403);
        }

        $data = json_decode($request->getContent(), true);
        $userId = $data['user_id'] ?? $request->request->get('userId');
        $month = $data['month'] ?? $request->request->get('month');
        $year = $data['year'] ?? $request->request->get('year');

        if (!$userId || !$month || !$year) {
            return new JsonResponse(['error' => 'Paramètres manquants'], 400);
        }

        $employee = $userRepo->find($userId);
        if (!$employee) {
            return new JsonResponse(['error' => 'Employé non trouvé'], 404);
        }

        // Create notification
        $notif = new PortalNotification();
        $notif->setUser($employee);
        $notif->setTitle('Signature Mensuelle attendue');
        $notif->setContent(sprintf('Votre signature est attendue pour le mois %d de %d.', $month, $year));
        $notif->setLink('/rh/valider-mes-heures?month=' . $month . '&year=' . $year);
        $notif->setType('SIGNATURE_REMINDER');
        
        $em->persist($notif);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/rh/validation/missing-list', name: 'app_rh_validation_missing_list', methods: ['GET'])]
    public function missingListSignature(Request $request, \App\Repository\UserRepository $userRepo, PortalMonthlyValidationRepository $validationRepo, PortalHoraireRepository $horaireRepo, AccessHelper $access): JsonResponse
    {
        if (!($access->canEdit('rh_validation') || $access->isFullView('rh_validation') || $access->isMagasinOnly('rh_validation'))) {
            return new JsonResponse(['error' => 'Accès refusé'], 403);
        }

        $month = $request->query->getInt('month');
        $year = $request->query->getInt('year');
        $magasin = $request->query->get('magasin');

        $startOfMonth = new \DateTime($year . '-' . $month . '-01 00:00:00');
        $endOfMonth = (clone $startOfMonth)->modify('last day of this month')->setTime(23, 59, 59);

        $qb = $userRepo->createQueryBuilder('u')
            ->where("u.magasin != 'Client' AND u.magasin IS NOT NULL");
        
        if ($access->isMagasinOnly('rh_validation')) {
            /** @var User $me */
            $me = $this->getUser();
            $qb->andWhere('u.magasin = :my_mag')->setParameter('my_mag', $me->getMagasin());
        } elseif ($magasin && $magasin !== 'all') {
            $qb->andWhere('u.magasin = :mag')->setParameter('mag', $magasin);
        }
        
        $users = $qb->getQuery()->getResult();
        
        // Get those who signed
        $allValidations = $validationRepo->findBy(['month' => $month, 'year' => $year]);
        $signedUserIds = array_map(fn($v) => $v->getUser()->getId(), array_filter($allValidations, fn($v) => $v->getSignature()));

        // Get those who have hours
        $userIdsWithHours = $horaireRepo->createQueryBuilder('h')
            ->select('DISTINCT IDENTITY(h.user)')
            ->where('h.startTime >= :start')
            ->andWhere('h.startTime <= :end')
            ->setParameter('start', $startOfMonth)
            ->setParameter('end', $endOfMonth)
            ->getQuery()
            ->getScalarResult();
        $userIdsWithHours = array_column($userIdsWithHours, 1);

        $missing = [];
        foreach ($users as $u) {
            // Exclude anyone with Full Access to this module (Directeur-like behavior)
            if ($access->isFullAccess('rh_validation', $u)) {
                continue;
            }

            if (in_array($u->getId(), $userIdsWithHours) && !in_array($u->getId(), $signedUserIds)) {
                $missing[] = [
                    'id' => $u->getId(),
                    'name' => $u->getPrenom() . ' ' . $u->getNom(),
                    'initials' => strtoupper(substr($u->getPrenom(), 0, 1) . substr($u->getNom(), 0, 1)),
                    'photo' => $u->getPhoto()
                ];
            }
        }

        return new JsonResponse(['users' => $missing]);
    }

    private function generatePdf(PortalMonthlyValidation $validation, array $horaires): void
    {
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        $logoPath = $this->getParameter('kernel.project_dir') . '/public/logo.svg';
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/svg+xml;base64,' . base64_encode($logoData);
        }

        $month = $validation->getMonth();
        $year = $validation->getYear();
        $startOfMonth = new \DateTime($year . '-' . $month . '-01 00:00:00');
        $endOfMonth = (clone $startOfMonth)->modify('last day of this month')->setTime(23, 59, 59);

        $daysMap = $this->buildDaysMapForMonth($startOfMonth, $horaires);

        $html = $this->renderView('rh/validation_pdf.html.twig', [
            'validation' => $validation,
            'daysMap' => $daysMap,
            'logoBase64' => $logoBase64,
            'startOfMonth' => $startOfMonth,
            'endOfMonth' => $endOfMonth,
            'month' => $month,
            'year' => $year,
        ]);

        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $output = $dompdf->output();
        
        $user = $validation->getUser();
        $magasin = $user->getMagasin() ?: 'Inconnu';
        $fullName = ucfirst(strtolower($user->getPrenom())) . strtoupper($user->getNom());
        
        // Structure: /storage/heure_validations/Year/Magasin/Employee/
        $saveDir = sprintf('%s/storage/heure_validations/%d/%s/%s', 
            $this->getParameter('kernel.project_dir'),
            $validation->getYear(),
            str_replace(['/', '\\'], '_', $magasin),
            str_replace(['/', '\\'], '_', $fullName)
        );

        if (!is_dir($saveDir)) {
            mkdir($saveDir, 0777, true);
        }

        file_put_contents($saveDir . '/' . $validation->getPdfName(), $output);
    }

    #[Route('/rh/valider-mes-heures/download/{id}', name: 'app_rh_validation_download')]
    public function downloadPdf(PortalMonthlyValidation $validation): Response
    {
        $user = $validation->getUser();
        $magasin = $user->getMagasin() ?: 'Inconnu';
        $fullName = ucfirst(strtolower($user->getPrenom())) . strtoupper($user->getNom());

        // New path
        $filePath = sprintf('%s/storage/heure_validations/%d/%s/%s/%s', 
            $this->getParameter('kernel.project_dir'),
            $validation->getYear(),
            str_replace(['/', '\\'], '_', $magasin),
            str_replace(['/', '\\'], '_', $fullName),
            $validation->getPdfName()
        );
        
        if (!file_exists($filePath)) {
            // Check previous hierarchy: /storage/heures_validations/Magasin/Firstname Lastname/Year/
            $oldFullName = sprintf('%s %s', ucfirst(strtolower($user->getPrenom())), ucfirst(strtolower($user->getNom())));
            $oldPath = sprintf('%s/storage/heures_validations/%s/%s/%d/%s', 
                $this->getParameter('kernel.project_dir'),
                $magasin,
                $oldFullName,
                $validation->getYear(),
                $validation->getPdfName()
            );
            if (file_exists($oldPath)) {
                $filePath = $oldPath;
            } elseif (file_exists($this->getParameter('kernel.project_dir') . '/public/uploads/validations/' . $validation->getPdfName())) {
                $filePath = $this->getParameter('kernel.project_dir') . '/public/uploads/validations/' . $validation->getPdfName();
            } else {
                throw $this->createNotFoundException('Le fichier PDF n\'existe pas.');
            }
        }

        return new Response(file_get_contents($filePath), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $validation->getPdfName() . '"'
        ]);
    }

    private function buildDaysMapForMonth(\DateTime $startOfMonth, array $horaires): array
    {
        $daysMap = [];
        $totalDays = (int)$startOfMonth->format('t');

        for ($i = 0; $i < $totalDays; $i++) {
            $dayDate = (clone $startOfMonth)->modify("+$i days");
            $dateKey = $dayDate->format('Y-m-d');
            $daysMap[$dateKey] = [
                'date' => $dayDate,
                'horaires' => []
            ];
        }

        foreach ($horaires as $h) {
            $startTime = $h->getStartTime();
            $endTime = $h->getEndTime();

            if (!$startTime || !$endTime) continue;

            $iterStart = \DateTime::createFromInterface($startTime);
            $overallEnd = \DateTime::createFromInterface($endTime);

            $isAllDay = ($startTime->format('H:i:s') === '00:00:00' && $endTime->format('H:i:s') === '00:00:00');
            if ($isAllDay && $startTime->getTimestamp() === $endTime->getTimestamp()) {
                $overallEnd->modify('+1 day');
            }

            while ($iterStart < $overallEnd) {
                $dateKey = $iterStart->format('Y-m-d');
                $iterEnd = (clone $iterStart)->modify('tomorrow')->setTime(0, 0, 0);
                if ($iterEnd > $overallEnd) {
                    $iterEnd = clone $overallEnd;
                }

                if (isset($daysMap[$dateKey])) {
                    $virtualH = clone $h;
                    $virtualH->setStartTime(clone $iterStart);
                    $virtualH->setEndTime(clone $iterEnd);
                    $daysMap[$dateKey]['horaires'][] = $virtualH;
                }

                $iterStart->modify('tomorrow')->setTime(0, 0, 0);
            }
        }

        return $daysMap;
    }

    #[Route('/rh/conge/api/employees', name: 'app_rh_conge_api_employees')]
    public function congeApiEmployees(Request $request, \App\Repository\UserRepository $userRepo): JsonResponse
    {
        if (!$this->access->canView('rh_conge')) {
            return new JsonResponse([], 403);
        }
        
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $mag = $request->query->get('magasin', '');
        
        if ($this->access->isMagasinOnly('rh_conge') && $mag !== $currentUser->getMagasin()) {
             $mag = $currentUser->getMagasin();
        }
        $employes = $userRepo->createQueryBuilder('u')
            ->where('u.magasin = :mag')
            ->setParameter('mag', $mag)
            ->orderBy('u.nom', 'ASC')
            ->getQuery()
            ->getResult();
        $data = array_map(fn($u) => ['id' => $u->getId(), 'prenom' => $u->getPrenom(), 'nom' => $u->getNom()], $employes);
        return new JsonResponse($data);
    }

    #[Route('/rh/conge/api/list', name: 'app_rh_conge_api_list')]
    public function congeApiList(Request $request, PortalCongeRepository $congeRepo, \App\Repository\UserRepository $userRepo): JsonResponse
    {
        if (!$this->access->canView('rh_conge')) {
            return new JsonResponse([], 403);
        }
        
        $userId = $request->query->get('user_id');
        $user   = $userRepo->find($userId);
        if (!$user) return new JsonResponse([]);

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        // Magasin check
        if ($this->access->isMagasinOnly('rh_conge') && $user->getMagasin() !== $currentUser->getMagasin()) {
            return new JsonResponse(['error' => 'Accès refusé'], 403);
        }
        $conges = $congeRepo->findBy(['user' => $user], ['createdAt' => 'DESC']);
        $data = array_map(fn($c) => [
            'id'        => $c->getId(),
            'startDate' => $c->getStartDate()->format('d/m/Y'),
            'endDate'   => $c->getEndDate()->format('d/m/Y'),
            'type'      => $c->getType(),
            'status'    => $c->getStatus(),
        ], $conges);
        return new JsonResponse($data);
    }

    #[Route('/rh/conge/rapports', name: 'app_rh_conge_print_tool')]
    public function congePrintTool(Request $request, PortalCongeRepository $congeRepo, \App\Repository\UserRepository $userRepo): Response
    {
        if (!$this->access->canView('rh_conge')) {
            throw $this->createAccessDeniedException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        // Magasin list
        $magasinsQb = $userRepo->createQueryBuilder('u')
            ->select('DISTINCT u.magasin')
            ->where('u.magasin IS NOT NULL')
            ->andWhere("u.magasin != 'Client'")
            ->orderBy('u.magasin', 'ASC');

        if ($this->access->isMagasinOnly('rh_conge')) {
            $magasinsQb->andWhere('u.magasin = :my_mag')
               ->setParameter('my_mag', $currentUser->getMagasin());
        }

        $magasins = $magasinsQb->getQuery()->getResult();
        $magasinList = array_map(fn($m) => $m['magasin'], $magasins);

        $selectedMagasin = $request->query->get('magasin');
        $selectedUserId  = $request->query->get('user_id');
        $selectedCongeId = $request->query->get('conge_id');

        $employes = [];
        $conges   = [];
        $selectedUser  = null;
        $selectedConge = null;

        if ($selectedMagasin) {
            $employes = $userRepo->createQueryBuilder('u')
                ->where('u.magasin = :mag')
                ->setParameter('mag', $selectedMagasin)
                ->orderBy('u.nom', 'ASC')
                ->getQuery()
                ->getResult();
        }

        if ($selectedUserId) {
            $selectedUser = $userRepo->find($selectedUserId);
            if ($selectedUser) {
                $conges = $congeRepo->findBy(
                    ['user' => $selectedUser, 'status' => ['APPROVED', 'REJECTED', 'PENDING', 'PROPOSED']],
                    ['createdAt' => 'DESC']
                );
            }
        }

        if ($selectedCongeId) {
            $selectedConge = $congeRepo->find($selectedCongeId);
        }

        return $this->render('rh/conge_print_tool.html.twig', [
            'magasins'       => $magasinList,
            'selectedMagasin'=> $selectedMagasin,
            'employes'       => $employes,
            'selectedUser'   => $selectedUser,
            'selectedUserId' => $selectedUserId,
            'conges'         => $conges,
            'selectedConge'  => $selectedConge,
            'selectedCongeId'=> $selectedCongeId,
        ]);
    }

    #[Route('/rh/conge/pdf/{id}', name: 'app_rh_conge_pdf')]
    public function congeGeneratePdf(PortalConge $conge): Response
    {
        if (!$this->access->canView('rh_conge')) {
            throw $this->createAccessDeniedException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        // Magasin check
        if ($this->access->isMagasinOnly('rh_conge') && $conge->getUser()->getMagasin() !== $currentUser->getMagasin()) {
            throw $this->createAccessDeniedException();
        }

        $logoPath   = $this->getParameter('kernel.project_dir') . '/public/logo.svg';
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $html = $this->renderView('rh/conge_pdf.html.twig', [
            'conge'      => $conge,
            'logoBase64' => $logoBase64,
        ]);

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $user     = $conge->getUser();
        $filename = sprintf('Conge_%s_%s_%s_au_%s.pdf',
            $user->getNom(),
            $user->getPrenom(),
            $conge->getStartDate()->format('d-m-Y'),
            $conge->getEndDate()->format('d-m-Y')
        );

        return new Response($dompdf->output(), 200, [
            'Content-Type'        => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }
}


