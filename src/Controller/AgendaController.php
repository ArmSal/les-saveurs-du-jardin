<?php



namespace App\Controller;



use App\Entity\PortalHoraire;

use App\Entity\PortalWeekLock;

use App\Entity\User;

use App\Repository\PortalHoraireRepository;

use App\Repository\PortalWeekLockRepository;

use App\Repository\UserRepository;

use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\JsonResponse;

use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;

use App\Service\AccessHelper;

use Symfony\Component\Routing\Annotation\Route;



class AgendaController extends AbstractController

{

    private AccessHelper $access;



    public function __construct(AccessHelper $access)

    {

        $this->access = $access;

    }



    #[Route('/agenda', name: 'app_agenda')]

    public function index(UserRepository $userRepo, PortalHoraireRepository $horaireRepo): Response

    {

        if (!$this->access->canView('agenda')) {

            throw $this->createAccessDeniedException();

        }



        /** @var User $user */

        $user = $this->getUser();

        $canEdit = $this->access->canEdit('agenda');

        $isFullView = $this->access->isFullView('agenda');

        $isMagasinOnly = $this->access->isMagasinOnly('agenda');

        $obsLevel = $this->access->getAccessLevel('user_observations');

        $canViewObservations = in_array($obsLevel, ['ACCES_TOTAL', 'ADMIN_MAGASIN']);



        if ($canEdit || $isFullView || $isMagasinOnly) {

            $qb = $userRepo->createQueryBuilder('u')

                ->where("u.magasin != 'Client'")

                ->andWhere("u.magasin IS NOT NULL");

                

            if ($isMagasinOnly) {

                $qb->andWhere('u.magasin = :my_magasin')

                   ->setParameter('my_magasin', $user->getMagasin());

            }



            $employes = $qb->orderBy('u.magasin', 'ASC')

                ->addOrderBy('u.nom', 'ASC')

                ->getQuery()

                ->getResult();



            $canLockWeeks = $this->access->canEdit('agenda');

            return $this->render('agenda/admin.html.twig', [

                'employes' => $employes,

                'canEdit' => $canEdit,

                'canLockWeeks' => $canLockWeeks,

                'isFullView' => $isFullView,

                'isMagasinOnly' => $isMagasinOnly,

                'canViewObservations' => $canViewObservations,

            ]);

        }



        // ACCES_PERSONNEL

        return $this->render('agenda/employe.html.twig', [

            'user' => $user,

            'magasin' => $user->getMagasin(),

        ]);

    }



    #[Route('/agenda/export/pdf', name: 'app_agenda_export_pdf', methods: ['GET'])]

    public function exportPdf(Request $request, PortalHoraireRepository $horaireRepo, \App\Repository\UserObservationRepository $observationRepo): Response

    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        if (!$this->access->canEdit('agenda')) {

            throw $this->createAccessDeniedException();

        }



        $monthStr = $request->query->get('month', date('Y-m'));

        $magasinFilter = $request->query->get('magasin');
        $userId = $request->query->get('user_id');

        $date = new \DateTime($monthStr . '-01');

        $year = (int) $date->format('Y');

        $month = (int) $date->format('m');

        $daysInMonth = (int) $date->format('t');



        $startOfMonth = clone $date;

        $endOfMonth = (clone $date)->modify('last day of this month')->setTime(23, 59, 59);



        // ── Extend to full calendar weeks (Mon–Sun) ──────────────────────────

        // Go back to Monday of the week containing the 1st

        $startDisplay = clone $startOfMonth;

        $startDisplay->setTime(0, 0, 0);

        $dowFirst = (int)$startDisplay->format('N'); // 1=Mon … 7=Sun

        if ($dowFirst > 1) {

            $startDisplay->modify('-' . ($dowFirst - 1) . ' days');

        }



        // S'arrêter au dernier jour du mois (ne pas compléter la dernière semaine)
        $endDisplay = clone $endOfMonth;



        // ── Build displayDays: one entry per calendar day shown ───────────────

        $weeksList        = [];

        $displayDays      = [];

        $dateToDisplayIdx = [];

        $weekColors = ['#e0f2fe', '#dcfce7', '#fef9c3', '#f3e8ff', '#fce7f3', '#ffedd5'];



        $cursor = clone $startDisplay;

        $cursor->setTime(0, 0, 0);

        $idx = 0;



        while ($cursor <= $endDisplay) {

            $d = (int)$cursor->format('j');

            $m = (int)$cursor->format('m');

            $y = (int)$cursor->format('Y');

            $weekNum = \App\Service\CalendarHelper::getCustomWeekNumber($cursor);



            if (!isset($weeksList[$weekNum])) {

                $weeksList[$weekNum] = 'S' . sprintf('%02d', $weekNum);

            }



            $displayDays[$idx] = [

                'date'           => clone $cursor,

                'day'            => $d,

                'month'          => $m,

                'year'           => $y,

                'isCurrentMonth' => ($m === $month && $y === $year),

                'weekNum'        => $weekNum,

                'dow'            => (int)$cursor->format('N'), // 1=Mon, 7=Sun

            ];

            $dateToDisplayIdx[$cursor->format('Y-m-d')] = $idx;

            $idx++;

            $cursor->modify('+1 day');

        }



        $totalDisplayDays = count($displayDays);



        // ── Week colour map ───────────────────────────────────────────────────

        $weekColorsMap = [];

        $cIdx = 0;

        foreach ($weeksList as $w => $wLabel) {

            $weekColorsMap[$w] = $weekColors[$cIdx % count($weekColors)];

            $cIdx++;

        }



        // ── Fetch horaires for the full display range ─────────────────────────

        $qb = $horaireRepo->createQueryBuilder('h')

            ->leftJoin('h.user', 'u')

            ->where('h.startTime <= :end')

            ->andWhere('h.endTime >= :start')

            ->andWhere("u.magasin != 'Client' AND u.magasin IS NOT NULL")

            ->setParameter('start', $startDisplay)

            ->setParameter('end', $endDisplay);



        if ($magasinFilter) {

            $qb->andWhere('u.magasin = :mag')->setParameter('mag', $magasinFilter);

        }



        if ($userId) {

            $qb->andWhere('u.id = :userId')->setParameter('userId', $userId);

        }



        $horaires = $qb->orderBy('u.magasin', 'ASC')

            ->addOrderBy('u.nom', 'ASC')

            ->getQuery()

            ->getResult();



        // ── Build report data, indexed by display-day index ───────────────────

        // reportData[magasin][userId] = [

        //   'user'  => User,

        //   'days'  => [idx => ['hours' => h, 'statuses' => []]],  (0-based)

        //   'weeks' => [weekNum => totalHoursInMonth],

        //   'total' => totalHoursInMonth

        // ]

        $reportData = [];



        foreach ($horaires as $h) {

            /** @var PortalHoraire $h */

            $u         = $h->getUser();

            $magasin   = $u->getMagasin() ?: 'Non assigné';

            $status    = $h->getStatus();

            $startTime = $h->getStartTime();

            $endTime   = $h->getEndTime();



            if (!$startTime || !$endTime) {

                continue;

            }



            $isAllDay = ($startTime->format('H:i:s') === '00:00:00' &&

                         $endTime->format('H:i:s')   === '00:00:00');



            $iterStart  = \DateTime::createFromInterface($startTime);

            $overallEnd = new \DateTime($endTime->format('Y-m-d H:i:s'));



            if ($isAllDay && $startTime->format('Y-m-d') === $endTime->format('Y-m-d')) {

                $overallEnd->modify('+1 day');

            }



            while ($iterStart < $overallEnd) {

                $iterEnd = (clone $iterStart)->modify('tomorrow')->setTime(0, 0, 0);

                if ($iterEnd > $overallEnd) {

                    $iterEnd = clone $overallEnd;

                }



                $dateKey = $iterStart->format('Y-m-d');



                if (isset($dateToDisplayIdx[$dateKey])) {

                    $dispIdx  = $dateToDisplayIdx[$dateKey];

                    $dd       = $displayDays[$dispIdx];

                    // All-day events count as a standard 7-hour working day, not 24h
                    $duration = $isAllDay
                        ? 7.0
                        : ($iterEnd->getTimestamp() - $iterStart->getTimestamp()) / 3600;



                    if (!isset($reportData[$magasin])) {

                        $reportData[$magasin] = [];

                    }



                    if (!isset($reportData[$magasin][$u->getId()])) {

                        $reportData[$magasin][$u->getId()] = [

                            'user'  => $u,

                            'days'  => array_fill(0, $totalDisplayDays, ['hours' => 0, 'statuses' => []]),

                            'weeks' => array_fill_keys(array_keys($weeksList), 0),

                            'total' => 0,

                        ];

                    }

                    // CFA - École: count hours like Actif, but also appear in the absences row
                    $isCFA = $status && stripos($status, 'CFA') !== false;

                    if (!$status || $status === 'Actif' || $isCFA) {

                        $reportData[$magasin][$u->getId()]['days'][$dispIdx]['hours'] += $duration;

                        // Week badge counts ALL days of the week (cross-month included)
                        $reportData[$magasin][$u->getId()]['weeks'][$dd['weekNum']] += $duration;

                        // Monthly total counts ONLY in-month days
                        if ($dd['isCurrentMonth']) {

                            $reportData[$magasin][$u->getId()]['total'] += $duration;

                        }

                        // CFA also shows in the absences/autres row
                        if ($isCFA) {

                            $reportData[$magasin][$u->getId()]['days'][$dispIdx]['statuses'][] = [

                                'label'     => $status,

                                'hours'     => $duration,

                                'isFullDay' => $isAllDay,

                            ];

                        }

                    } else {

                        // All other statuses: no hour count, display in absences row only
                        $reportData[$magasin][$u->getId()]['days'][$dispIdx]['statuses'][] = [

                            'label'     => $status,

                            'hours'     => $duration,

                            'isFullDay' => $isAllDay,

                        ];

                    }

                }



                $iterStart->modify('tomorrow')->setTime(0, 0, 0);

            }

        }



        // ── Month name ────────────────────────────────────────────────────────

        $monthNamesFr = [

            1 => 'Janvier',   2 => 'Février',   3 => 'Mars',

            4 => 'Avril',     5 => 'Mai',        6 => 'Juin',

            7 => 'Juillet',   8 => 'Août',       9 => 'Septembre',

            10 => 'Octobre',  11 => 'Novembre',  12 => 'Décembre',

        ];

        $monthNameFr = $monthNamesFr[$month] . ' ' . $year;



        // ── Logo ──────────────────────────────────────────────────────────────

        $logoPath   = $this->getParameter('kernel.project_dir') . '/public/logo.svg';

        $logoData   = file_get_contents($logoPath);

        $logoBase64 = 'data:image/svg+xml;base64,' . base64_encode($logoData);



        // ── Observations map (userId => UserObservation) ──────────────────────

        $moisStr         = sprintf('%04d-%02d', $year, $month);

        $allObservations = $observationRepo->findAllWithFilters($magasinFilter ?: null, $moisStr);

        $observationsMap = [];

        foreach ($allObservations as $obs) {

            $observationsMap[$obs->getUser()->getId()] = $obs;

        }



        // ── Status Acronyms for Report ────────────────────────────────────────
        $statusAcronyms = [
            'CFA - Ecole'         => 'CFA-E',
            'Congé Payé'          => 'CP',
            'Congé sans solde'    => 'CSS',
            'Absence injustifiée' => 'AI',
            'Arret de travail'    => 'ARdT',
            'Accident de travail' => 'ACdT',
            'Congé Parental'      => 'CPar',
            'Autre'               => 'Autre',
        ];

        $legend = [
            'CFA-E' => 'SCFA-Ecole',
            'CP' => 'Congé Payé',
            'CSS' => 'Congé Sans Solde',
            'AI' => 'Absence Injustifiée',
            'ARdT' => 'Arret de Travail',
            'ACdT' => 'Accident de Travail',
            'CPar' => 'Congé Parental',
            'Autre' => 'Autre',
        ];

        // ── Render ────────────────────────────────────────────────────────────

        $html = $this->renderView('agenda/report_pdf.html.twig', [

            'reportData'       => $reportData,

            'monthName'        => $monthNameFr,

            'displayDays'      => $displayDays,

            'totalDisplayDays' => $totalDisplayDays,

            'weeksList'        => $weeksList,

            'weekColorsMap'    => $weekColorsMap,

            'year'             => $year,

            'month'            => $month,

            'logoBase64'       => $logoBase64,

            'observationsMap'  => $observationsMap,

            'statusAcronyms'   => $statusAcronyms,

            'legend'           => $legend,

        ]);



        $dompdf = new \Dompdf\Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'landscape');

        $dompdf->render();



        return new Response(

            $dompdf->output(),

            200,

            [

                'Content-Type' => 'application/pdf',

                'Content-Disposition' => 'inline; filename="rapport_horaires.pdf"',

                'Cache-Control' => 'no-cache, no-store, must-revalidate',

                'Pragma' => 'no-cache',

                'Expires' => '0',

            ]

        );

    }



    #[Route('/agenda/export/detailed-report', name: 'app_agenda_export_detailed_report', methods: ['GET'])]

    public function exportDetailedReport(Request $request, PortalHoraireRepository $horaireRepo, UserRepository $userRepo, AccessHelper $access): Response

    {

        if (!$access->canEdit('agenda')) {

            throw $this->createAccessDeniedException();

        }



        $userId = $request->query->get('user_id');

        $magasin = $request->query->get('magasin');

        $startStr = $request->query->get('start');

        $endStr = $request->query->get('end');



        if (!$startStr || !$endStr) {

            return new Response("Dates de début et de fin requises.", 400);

        }



        try {

            $start = new \DateTime($startStr . ' 00:00:00');

            $end = new \DateTime($endStr . ' 23:59:59');

        } catch (\Exception $e) {

            return new Response("Format de date invalide.", 400);

        }



        $qb = $horaireRepo->createQueryBuilder('h')

            ->leftJoin('h.user', 'u')

            ->where('h.startTime <= :end')

            ->andWhere('h.endTime >= :start')

            ->setParameter('start', $start)

            ->setParameter('end', $end);



        if ($userId) {

            $qb->andWhere('u.id = :userId')

               ->setParameter('userId', $userId);

        }



        if ($magasin && $magasin !== 'all') {

            $qb->andWhere('u.magasin = :magasin')

               ->setParameter('magasin', $magasin);

        }



        $horaires = $qb->orderBy('u.nom', 'ASC')

            ->addOrderBy('h.startTime', 'ASC')

            ->getQuery()

            ->getResult();



        // Organize data by user for the report

        $userData = [];

        foreach ($horaires as $h) {

            $u = $h->getUser();

            $uid = $u->getId();

            if (!isset($userData[$uid])) {

                $userData[$uid] = [

                    'user' => $u,

                    'horaires' => []

                ];

            }

            $userData[$uid]['horaires'][] = $h;

        }



        $logoPath = $this->getParameter('kernel.project_dir') . '/public/logo.svg';

        $logoBase64 = '';

        if (file_exists($logoPath)) {

            $logoBase64 = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoPath));

        }



        $statusAcronyms = [
            'CFA - Ecole'         => 'CFA-E',
            'Congé Payé'          => 'CP',
            'Congé sans solde'    => 'CSS',
            'Absence injustifiée' => 'AI',
            'Arret de travail'    => 'ARdT',
            'Accident de travail' => 'ACdT',
            'Congé Parental'      => 'CPar',
            'Autre'               => 'Autre',
        ];

        $legend = [
            'CFA-E' => 'SCFA-Ecole',
            'CP' => 'Congé Payé',
            'CSS' => 'Congé Sans Solde',
            'AI' => 'Absence Injustifiée',
            'ARdT' => 'Arret de Travail',
            'ACdT' => 'Accident de Travail',
            'CPar' => 'Congé Parental',
            'Autre' => 'Autre',
        ];

        $html = $this->renderView('agenda/detailed_report_pdf.html.twig', [

            'userData' => $userData,

            'start' => $start,

            'end' => $end,

            'logoBase64' => $logoBase64,

            'statusAcronyms' => $statusAcronyms,

            'legend' => $legend,

        ]);



        $dompdf = new \Dompdf\Dompdf();

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();



        return new Response(

            $dompdf->output(),

            200,

            [

                'Content-Type' => 'application/pdf',

                'Content-Disposition' => 'inline; filename="rapport_horaire_detaille.pdf"',

            ]

        );

    }



    #[Route('/agenda/export/calendar', name: 'app_agenda_export_calendar', methods: ['GET'])]
    public function exportCalendarPdf(Request $request, PortalHoraireRepository $horaireRepo, UserRepository $userRepo, AccessHelper $access): Response
    {
        if (!$access->canView('agenda')) {
            throw $this->createAccessDeniedException();
        }

        $magasin = $request->query->get('magasin');
        $userId = $request->query->get('user_id');
        $startStr = $request->query->get('start');
        $endStr = $request->query->get('end');

        // Default to current week if no dates provided
        if (!$startStr || !$endStr) {
            $today = new \DateTime();
            $start = clone $today;
            $start->modify('monday this week');
            $end = clone $start;
            $end->modify('+7 days'); // Monday to Monday (exclusive) = 7 days (Mon-Sun)
        } else {
            try {
                $start = new \DateTime($startStr . ' 00:00:00');
                // End date is exclusive (FullCalendar style), so +1 day after Sunday
                $end = new \DateTime($endStr . ' 00:00:00');
            } catch (\Exception $e) {
                $today = new \DateTime();
                $start = clone $today;
                $start->modify('monday this week');
                $end = clone $start;
                $end->modify('+7 days');
            }
        }

        $qb = $horaireRepo->createQueryBuilder('h')
            ->leftJoin('h.user', 'u')
            ->where('h.startTime < :end')
            ->andWhere('h.endTime >= :start')
            ->andWhere("u.magasin != 'Client'")
            ->setParameter('start', $start)
            ->setParameter('end', $end);

        if ($userId) {
            $qb->andWhere('u.id = :userId')
               ->setParameter('userId', $userId);
        }

        if ($magasin && $magasin !== 'all') {
            $qb->andWhere('u.magasin = :magasin')
               ->setParameter('magasin', $magasin);
        }

        // ACCES_PERSONNEL: Only show current user's events
        if ($access->isPersonalAccess('agenda')) {
            /** @var User $currentUser */
            $currentUser = $this->getUser();
            $qb->andWhere('h.user = :current_user')
               ->setParameter('current_user', $currentUser);
        }

        $horaires = $qb->orderBy('u.nom', 'ASC')
            ->addOrderBy('h.startTime', 'ASC')
            ->getQuery()
            ->getResult();

        // Organize by day
        $days = [];
        $current = clone $start;
        while ($current < $end) {
            $dateKey = $current->format('Y-m-d');
            $days[$dateKey] = [
                'date' => clone $current,
                'users' => [],
                'allDayEvents' => []
            ];
            $current->modify('+1 day');
        }

        foreach ($horaires as $h) {
            $hStart = $h->getStartTime();
            $hEnd = $h->getEndTime();
            
            // All-day event detection
            $isAllDay = ($hStart->format('H:i:s') === '00:00:00' && 
                         $hEnd->format('H:i:s') === '00:00:00');
            
            // For multi-day events, add to all days they span
            $currentDay = clone $hStart;
            $currentDay->setTime(0, 0, 0);
            $endDay = clone $hEnd;
            $endDay->setTime(0, 0, 0);
            
            while ($currentDay <= $endDay) {
                $dateKey = $currentDay->format('Y-m-d');
                if (isset($days[$dateKey])) {
                    if ($isAllDay) {
                        $days[$dateKey]['allDayEvents'][] = $h;
                    } else {
                        $u = $h->getUser();
                        $uid = $u->getId();
                        if (!isset($days[$dateKey]['users'][$uid])) {
                            $days[$dateKey]['users'][$uid] = [
                                'user' => $u,
                                'shifts' => []
                            ];
                        }
                        $days[$dateKey]['users'][$uid]['shifts'][] = $h;
                    }
                }
                $currentDay->modify('+1 day');
            }
        }

        $logoPath = $this->getParameter('kernel.project_dir') . '/public/logo.svg';
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoBase64 = 'data:image/svg+xml;base64,' . base64_encode(file_get_contents($logoPath));
        }

        $html = $this->renderView('agenda/agenda_print.html.twig', [
            'days' => $days,
            'start' => $start,
            'end' => $end,
            'logoBase64' => $logoBase64,
            'magasin' => $magasin,
        ]);

        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        return new Response(
            $dompdf->output(),
            200,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'inline; filename="planning_horaires.pdf"',
            ]
        );
    }







    #[Route('/agenda/api/events', name: 'app_agenda_api_events', methods: ['GET'])]

    public function getEvents(Request $request, PortalHoraireRepository $horaireRepo, UserRepository $userRepo, EntityManagerInterface $em, AccessHelper $access): JsonResponse

    {

        $userId = $request->query->get('user_id');

        $magasin = $request->query->get('magasin');

        $startStr = $request->query->get('start');

        $endStr = $request->query->get('end');



        $qb = $horaireRepo->createQueryBuilder('h')

            ->leftJoin('h.user', 'u');



        if ($startStr && $endStr) {

            try {

                $start = new \DateTime($startStr);

                $end = new \DateTime($endStr);

                $qb->andWhere('h.startTime <= :end')

                   ->andWhere('h.endTime >= :start')

                   ->setParameter('start', $start)

                   ->setParameter('end', $end);

            } catch (\Exception $e) {

                // Ignore invalid format, fetch all

            }

        }



        if ($userId) {

            $qb->andWhere('h.user = :user_id')

                ->setParameter('user_id', $userId);

        } else {

            /** @var User $currentUser */

            $currentUser = $this->getUser();



            if ($access->isFullAccess('agenda') || $access->isFullView('agenda')) {

                // No additional filtering, see all

            } else if ($access->isMagasinOnly('agenda') || $access->canEdit('agenda')) {

                // Restricted to current user's magasin

                $qb->andWhere('u.magasin = :my_magasin')

                   ->setParameter('my_magasin', $currentUser->getMagasin());

            } else {

                // ACCES_PERSONNEL: Only current user's events

                $qb->andWhere('h.user = :current_user')

                   ->setParameter('current_user', $currentUser);

            }

        }



        if ($magasin) {

            $qb->andWhere('u.magasin = :magasin')

                ->setParameter('magasin', $magasin);

        }



        $horaires = $qb->getQuery()->getResult();

        $events = [];

        $today = (new \DateTime())->setTime(0, 0, 0);

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        // Check if we need to filter by week lock
        // Read-only users (LECTURE_TOTALE, LECTURE_MAGASIN, ACCES_PERSONNEL) cannot see events for locked weeks
        $shouldCheckWeekLock = !$access->canEdit('agenda') && !$access->isFullAccess('agenda');
        $lockStates = []; // [magasin][year][week] => isLocked

        if ($shouldCheckWeekLock) {
            // Pre-fetch locks for the range to avoid N+1 queries
            if (isset($start) && isset($end)) {
                $startWeek = \App\Service\CalendarHelper::getCustomWeekNumber($start);
                $startYear = \App\Service\CalendarHelper::getCustomYearForWeek($start);
                $endWeek = \App\Service\CalendarHelper::getCustomWeekNumber($end);
                $endYear = \App\Service\CalendarHelper::getCustomYearForWeek($end);

                // For simplicity, we just fetch all relevant locks in the potential year range
                $locks = $em->getRepository(PortalWeekLock::class)->createQueryBuilder('wl')
                    ->where('wl.year >= :startYear AND wl.year <= :endYear')
                    ->setParameter('startYear', min($startYear, $endYear))
                    ->setParameter('endYear', max($startYear, $endYear))
                    ->getQuery()
                    ->getResult();
                
                foreach ($locks as $lock) {
                    /** @var PortalWeekLock $lock */
                    $mag = trim((string)$lock->getMagasin());
                    $yr = (int)$lock->getYear();
                    $wk = (int)$lock->getWeekNumber();
                    $lockStates[$mag][$yr][$wk] = $lock->isLocked();
                }
            }
        }

        foreach ($horaires as $horaire) {
            /** @var PortalHoraire $horaire */
            $user = $horaire->getUser();

            // Check week lock for read-only users
            if ($shouldCheckWeekLock) {
                $eventMagasin = trim((string)$user->getMagasin());
                $eventStartTime = $horaire->getStartTime();
                $eventWeek = (int)\App\Service\CalendarHelper::getCustomWeekNumber($eventStartTime);
                $eventYear = (int)\App\Service\CalendarHelper::getCustomYearForWeek($eventStartTime);

                $isLockedByWeek = $lockStates[$eventMagasin][$eventYear][$eventWeek] ?? true;
                if ($eventMagasin !== '' && $isLockedByWeek) {
                    // Skip this event - week is locked and user has read-only access (Non Visible)
                    continue;
                }
            }

            $eventColor = $horaire->getColor() ?: ($user->getCalendarColor() ?: '#4f46e5');

            

            $statusSuffix = ($horaire->getStatus() && $horaire->getStatus() !== 'Actif') ? ' (' . $horaire->getStatus() . ')' : '';

            

            // All-day event detection: both times at midnight

            $isAllDay = ($horaire->getStartTime()->format('H:i:s') === '00:00:00' && 

                         $horaire->getEndTime()->format('H:i:s') === '00:00:00');



            $jsonEnd = new \DateTime($horaire->getEndTime()->format('Y-m-d H:i:s'));

            if ($isAllDay) {

                // For FullCalendar to display correctly (exclusive end date), we add 1 day to our storage format

                $jsonEnd->modify('+1 day');

            }



            $isLocked = false;

            

            if (!$access->canEdit('agenda')) {

                $isLocked = true;

            } elseif ($this->isMonthLocked($user, $horaire->getStartTime(), $em)) {

                $isLocked = true;

            }



            $events[] = [

                'id' => $horaire->getId(),

                'title' => $user->getPrenom() . ' ' . $user->getNom() . $statusSuffix . ($horaire->getNote() ? ' - ' . $horaire->getNote() : ''),

                'start' => $horaire->getStartTime()->format('Y-m-d\TH:i:s'),

                'end' => $jsonEnd->format('Y-m-d\TH:i:s'),

                'allDay' => $isAllDay,

                'editable' => !$isLocked,

                'startEditable' => !$isLocked,

                'durationEditable' => !$isLocked,

                'extendedProps' => [

                    'user_id' => $user->getId(),

                    'magasin' => $user->getMagasin(),

                    'note' => $horaire->getNote(),

                    'color' => $horaire->getColor(),

                    'status' => $horaire->getStatus(),

                    'prenom' => $user->getPrenom(),

                    'nom' => $user->getNom(),

                    'isLocked' => $isLocked,

                ],

                'backgroundColor' => $eventColor,

                'borderColor' => $eventColor,

            ];

        }



        if (isset($start) && isset($end)) {

            $userQb = $userRepo->createQueryBuilder('u')

                ->where("u.magasin != 'Client'")

                ->andWhere("u.is_active = true");



            if ($userId) {

                $userQb->andWhere('u.id = :uid')->setParameter('uid', $userId);

            } else {

                /** @var \App\Entity\User $currentUser */

                $currentUser = $this->getUser();

                if ($access->isFullAccess('agenda') || $access->isFullView('agenda')) {

                    // No filter

                } else if ($access->isMagasinOnly('agenda') || $access->canEdit('agenda')) {

                    $userQb->andWhere('u.magasin = :mag')->setParameter('mag', $currentUser->getMagasin());

                } else {

                    $userQb->andWhere('u.id = :uid')->setParameter('uid', $currentUser->getId());

                }

            }



            $users = $userQb->getQuery()->getResult();

            $startYear = (int)$start->format('Y');

            $endYear = (int)$end->format('Y');



            foreach ($users as $u) {

                if ($dn = $u->getDateNaissance()) {

                    for ($y = $startYear; $y <= $endYear; $y++) {

                        $bday = (clone $dn)->setDate($y, (int)$dn->format('m'), (int)$dn->format('d'));

                        $bday->setTime(0, 0, 0);



                        if ($bday >= $start && $bday <= $end) {

                            $events[] = [

                                'id' => 'bday-' . $u->getId() . '-' . $y,

                                'title' => '🎂 ' . $u->getPrenom() . ' ' . $u->getNom(),

                                'start' => $bday->format('Y-m-d\T00:00:00'),

                                'end' => (clone $bday)->modify('+1 day')->format('Y-m-d\T00:00:00'),

                                'allDay' => true,

                                'editable' => false,

                                'startEditable' => false,

                                'durationEditable' => false,

                                'backgroundColor' => '#ec4899', // Pink

                                'borderColor' => '#ec4899',

                                'extendedProps' => [

                                    'isBirthday' => true,

                                    'user_id' => $u->getId(),

                                    'magasin' => $u->getMagasin(),

                                    'note' => '',

                                    'color' => '#ec4899',

                                    'status' => 'Anniversaire',

                                    'prenom' => $u->getPrenom(),

                                    'nom' => $u->getNom(),

                                    'isLocked' => true,

                                ],

                            ];

                        }

                    }

                }

            }



            // Holidays logic

            for ($y = $startYear; $y <= $endYear; $y++) {

                $holidays = \App\Service\CalendarHelper::getHolidays($y);

                foreach ($holidays as $dateStr => $name) {

                    $holidayDate = new \DateTime($dateStr);

                    $holidayDate->setTime(0, 0, 0);



                    if ($holidayDate >= $start && $holidayDate <= $end) {

                        $events[] = [

                            'id' => 'holiday-' . $dateStr,

                            'title' => '🚩 ' . $name,

                            'start' => $dateStr . 'T00:00:00',

                            'end' => (clone $holidayDate)->modify('+1 day')->format('Y-m-d\T00:00:00'),

                            'allDay' => true,

                            'editable' => false,

                            'startEditable' => false,

                            'durationEditable' => false,

                            'backgroundColor' => '#f59e0b', // Amber/Orange

                            'borderColor' => '#f59e0b',

                            'extendedProps' => [

                                'isHoliday' => true,

                                'note' => $name,

                                'color' => '#f59e0b',

                                'status' => 'Férié',

                                'isLocked' => true,

                            ],

                        ];

                    }

                }

            }

        }



        return $this->json($events);
    }





    #[Route('/agenda/api/save', name: 'app_agenda_api_save', methods: ['POST'])]

    public function saveEvent(Request $request, EntityManagerInterface $em, UserRepository $userRepo, PortalHoraireRepository $horaireRepo, AccessHelper $access): JsonResponse

    {

        if (!$access->canEdit('agenda')) {

            throw $this->createAccessDeniedException();

        }

        $data = json_decode($request->getContent(), true);



        $userId = $data['user_id'] ?? null;

        $start = $data['start'] ?? null;

        $end = $data['end'] ?? null;

        $note = $data['note'] ?? '';

        $color = $data['color'] ?? null;



        if (!$userId || !$start || !$end) {

            return $this->json(['error' => 'Missing data'], 400);

        }



        $user = $userRepo->find($userId);

        if (!$user) {

            return $this->json(['error' => 'User not found'], 404);

        }



        $startDateTime = new \DateTime($start);

        

        if ($this->isMonthLocked($user, $startDateTime, $em)) {

            return $this->json(['success' => false, 'error' => 'Les horaires de ce mois sont déjà validés et signés. Annulez la validation pour modifier.']);

        }



        $weekNum = \App\Service\CalendarHelper::getCustomWeekNumber($startDateTime);

        $yearNum = \App\Service\CalendarHelper::getCustomYearForWeek($startDateTime);



        $horaire = new PortalHoraire();

        $horaire->setUser($user);



        $startDt = new \DateTime($start);

        $endDt = new \DateTime($end);

        $status = $data['status'] ?? 'Actif';



        // All-day logic adjustment:

        $isAllDay = ($startDt->format('H:i:s') === '00:00:00' && $endDt->format('H:i:s') === '00:00:00' && $startDt <= $endDt);

        

        if ($isAllDay && $status === 'Actif') {

            return $this->json(['success' => false, 'error' => 'Un horaire "Toute la journée" ne peut pas être "Actif". Veuillez choisir un type d\'absence.']);

        }



        // We no longer subtract 1 day here because the Modal sends inclusive dates.

        // Single day (26th to 26th) = stored as 26th to 26th.

        // Two days (26th to 27th) = stored as 26th to 27th.



        $horaire->setStartTime($startDt);

        $horaire->setEndTime($endDt);

        $horaire->setNote($note);

        $horaire->setStatus($status);

        if ($color) {

            $horaire->setColor($color);

        }



        // Check for overlap

        if ($horaireRepo->checkOverlap($user, $startDt, $endDt)) {

            return $this->json(['success' => false, 'error' => 'Cet employé a déjà un horaire ou un congé sur cette période.']);

        }



        $em->persist($horaire);

        $em->flush();



        return $this->json(['success' => true, 'id' => $horaire->getId()]);

    }





    #[Route('/agenda/api/delete/{id}', name: 'app_agenda_api_delete', methods: ['DELETE'])]

    public function deleteEvent(PortalHoraire $horaire, EntityManagerInterface $em, AccessHelper $access): JsonResponse

    {

        if (!$access->canEdit('agenda')) {

            throw $this->createAccessDeniedException();

        }



        if ($this->isMonthLocked($horaire->getUser(), $horaire->getStartTime(), $em)) {

            return $this->json(['success' => false, 'error' => 'Impossible de supprimer : ce mois est déjà validé et signé.']);

        }



        $em->remove($horaire);

        $em->flush();



        return $this->json(['success' => true]);

    }



    #[Route('/agenda/api/update/{id}', name: 'app_agenda_api_update', methods: ['POST'])]

    public function updateEvent(PortalHoraire $horaire, Request $request, EntityManagerInterface $em, PortalHoraireRepository $horaireRepo, AccessHelper $access): JsonResponse

    {

        if (!$access->canEdit('agenda')) {

            throw $this->createAccessDeniedException();

        }



        if ($this->isMonthLocked($horaire->getUser(), $horaire->getStartTime(), $em)) {

            return $this->json(['success' => false, 'error' => 'Impossible de modifier cet horaire : le mois est déjà validé et signé.']);

        }



        $data = json_decode($request->getContent(), true);

        $today = (new \DateTime())->setTime(0, 0, 0);



        if (isset($data['start'])) {

            $newStart = new \DateTime($data['start']);

            $horaire->setStartTime($newStart);

        }



        if (isset($data['end']) && !empty($data['end'])) {

            $endDt = new \DateTime($data['end']);

            

            // Adjust only for transitions from FullCalendar (exclusive end)

            $startDt = $horaire->getStartTime();

            if ($startDt->format('H:i:s') === '00:00:00' && $endDt->format('H:i:s') === '00:00:00' && $startDt < $endDt) {

                // FC sends 27th for a 1-day event on the 26th. We store it as 26th.

                $endDt->modify('-1 day');

            }

            

            $horaire->setEndTime($endDt);

        } elseif (isset($data['start']) && $horaire->getStartTime()->format('H:i:s') === '00:00:00') {

            // If dragged to all-day but no end provided, default to same as start for 1 day

            $horaire->setEndTime(clone $horaire->getStartTime());

        }



        if (isset($data['color'])) {

            $horaire->setColor($data['color']);

        }



        if (isset($data['note'])) {

            $horaire->setNote($data['note']);

        }



        if (isset($data['status'])) {

            $horaire->setStatus($data['status']);

        }



        // Final validation for All-Day vs Status

        $currStart = $horaire->getStartTime();

        $currEnd = $horaire->getEndTime();

        $isAllDay = ($currStart->format('H:i:s') === '00:00:00' && $currEnd->format('H:i:s') === '00:00:00');

        if ($isAllDay && $horaire->getStatus() === 'Actif') {

             return $this->json(['success' => false, 'error' => 'Un horaire "Toute la journée" ne peut pas être "Actif".']);

        }



        // Check for overlap before flushing

        if ($horaireRepo->checkOverlap($horaire->getUser(), $horaire->getStartTime(), $horaire->getEndTime(), $horaire->getId())) {

            return $this->json(['success' => false, 'error' => 'Cet employé a déjà un horaire ou un congé sur cette période.']);

        }



        $em->flush();



        return $this->json(['success' => true]);

    }



    #[Route('/agenda/api/user-color/{id}', name: 'app_agenda_api_user_color', methods: ['POST'])]

    public function updateUserColor(User $user, Request $request, EntityManagerInterface $em, PortalHoraireRepository $horaireRepo, AccessHelper $access): JsonResponse

    {

        if (!$access->canEdit('agenda')) {

            throw $this->createAccessDeniedException();

        }

        $data = json_decode($request->getContent(), true);

        

        if (isset($data['color'])) {

            $newColor = $data['color'];

            $user->setCalendarColor($newColor);

            

            // Sync all existing entries to the new color

            $horaires = $horaireRepo->findBy(['user' => $user]);

            foreach ($horaires as $h) {

                $h->setColor($newColor);

            }

            

            $em->flush();

            return $this->json(['success' => true]);

        }

        

        return $this->json(['success' => false], 400);

    }



    #[Route('/agenda/api/duplicate-week', name: 'app_agenda_api_duplicate_week', methods: ['POST'])]

    public function duplicateWeek(Request $request, EntityManagerInterface $em, PortalHoraireRepository $horaireRepo, AccessHelper $access): JsonResponse

    {

        if (!$access->canEdit('agenda')) {

            throw $this->createAccessDeniedException();

        }

        $data = json_decode($request->getContent(), true);



        $magasin = $data['magasin'] ?? null;

        $sourceWeek = $data['source_week'] ?? null;

        $targetWeek = $data['target_week'] ?? null;



        if (!$magasin || !$sourceWeek || !$targetWeek) {

            return $this->json(['success' => false, 'error' => 'Données manquantes']);

        }



        try {

            $sourceStart = new \DateTime($sourceWeek);

            $targetStart = new \DateTime($targetWeek);

        } catch (\Exception $e) {

            return $this->json(['success' => false, 'error' => 'Format de semaine invalide']);

        }



        $sourceEnd = (clone $sourceStart)->modify('+7 days');

        $interval = $sourceStart->diff($targetStart);



        $qb = $horaireRepo->createQueryBuilder('h')

            ->leftJoin('h.user', 'u')

            ->where('h.startTime >= :sStart')

            ->andWhere('h.startTime < :sEnd')

            ->andWhere('u.magasin = :magasin')

            ->andWhere("h.status = 'Actif'")

            ->setParameter('sStart', $sourceStart)

            ->setParameter('sEnd', $sourceEnd)

            ->setParameter('magasin', $magasin);



        $sourceEvents = $qb->getQuery()->getResult();

        $copied = 0;

        $skipped = 0;



        foreach ($sourceEvents as $h) {

            /** @var PortalHoraire $h */

            $newStart = new \DateTime($h->getStartTime()->format('Y-m-d H:i:s'));

            $newStart->add($interval);

            $newEnd = $h->getEndTime() ? new \DateTime($h->getEndTime()->format('Y-m-d H:i:s')) : clone $newStart;

            if ($h->getEndTime()) {

                $newEnd->add($interval);

            }



            // Check if target month is locked (signed)
            if ($this->isMonthLocked($h->getUser(), $newStart, $em)) {
                $skipped++;
                continue;
            }



            // Check overlap

            if ($horaireRepo->checkOverlap($h->getUser(), $newStart, $newEnd)) {

                $skipped++;

                continue;

            }



            // Create new

            $newH = new PortalHoraire();

            $newH->setUser($h->getUser());

            $newH->setStartTime($newStart);

            $newH->setEndTime($newEnd);

            $newH->setStatus('Actif');

            $newH->setColor($h->getColor());

            $newH->setNote($h->getNote());

            

            $em->persist($newH);

            $copied++;

        }



        $em->flush();



        return $this->json(['success' => true, 'copied' => $copied, 'skipped' => $skipped]);

    }

    #[Route('/agenda/api/week-lock/status', name: 'app_agenda_api_week_lock_status', methods: ['GET'])]
    public function getWeekLockStatus(Request $request, EntityManagerInterface $em, AccessHelper $access, PortalWeekLockRepository $weekLockRepo): JsonResponse
    {
        if (!$access->canEdit('agenda')) {
            throw $this->createAccessDeniedException();
        }

        $week = $request->query->get('week');
        $year = $request->query->get('year');
        $magasin = $request->query->get('magasin');

        if (!$week || !$year) {
            return $this->json(['error' => 'Week and year required'], 400);
        }

        /** @var User $user */
        $user = $this->getUser();
        $isFullAccess = $access->isFullAccess('agenda');

        // ACCES_MAGASIN can only check their own magasin
        if (!$isFullAccess && $magasin && $magasin !== $user->getMagasin()) {
            return $this->json(['error' => 'Access denied'], 403);
        }

        if ($magasin) {
            $lock = $weekLockRepo->findByWeekAndMagasin((int)$week, (int)$year, $magasin);
            return $this->json([
                'magasin' => $magasin,
                'week' => (int)$week,
                'year' => (int)$year,
                'isLocked' => $lock ? $lock->isLocked() : true,
                'lockedBy' => $lock && $lock->getLockedBy() ? $lock->getLockedBy()->getPrenom() . ' ' . $lock->getLockedBy()->getNom() : null,
                'lockedAt' => $lock && $lock->getLockedAt() ? $lock->getLockedAt()->format('Y-m-d H:i:s') : null,
            ]);
        }

        // Get all locked magasins for this week
        $lockedMagasins = $weekLockRepo->findLockedMagasinsForWeek((int)$week, (int)$year);

        return $this->json([
            'week' => (int)$week,
            'year' => (int)$year,
            'lockedMagasins' => $lockedMagasins,
        ]);
    }

    #[Route('/agenda/api/week-lock/toggle', name: 'app_agenda_api_week_lock_toggle', methods: ['POST'])]
    public function toggleWeekLock(Request $request, EntityManagerInterface $em, AccessHelper $access, PortalWeekLockRepository $weekLockRepo): JsonResponse
    {
        if (!$access->canEdit('agenda')) {
            throw $this->createAccessDeniedException();
        }

        $data = json_decode($request->getContent(), true);
        $week = $data['week'] ?? null;
        $year = $data['year'] ?? null;
        $magasin = $data['magasin'] ?? null;

        if (!$week || !$year || !$magasin) {
            return $this->json(['success' => false, 'error' => 'Week, year and magasin required'], 400);
        }

        /** @var User $user */
        $user = $this->getUser();
        $isFullAccess = $access->isFullAccess('agenda');

        // ACCES_MAGASIN can only lock their own magasin
        if (!$isFullAccess && $magasin !== $user->getMagasin()) {
            return $this->json(['success' => false, 'error' => 'Access denied'], 403);
        }

        $lock = $weekLockRepo->findByWeekAndMagasin((int)$week, (int)$year, $magasin);

        if (!$lock) {
            $lock = new PortalWeekLock();
            $lock->setMagasin($magasin);
            $lock->setWeekNumber((int)$week);
            $lock->setYear((int)$year);
            $lock->setIsLocked(false);
        } else {
            $lock->setIsLocked(!$lock->isLocked());
        }

        $lock->setLockedBy($user);
        $lock->setLockedAt(new \DateTime());

        $em->persist($lock);
        $em->flush();

        return $this->json([
            'success' => true,
            'isLocked' => $lock->isLocked(),
            'magasin' => $magasin,
            'week' => (int)$week,
            'year' => (int)$year,
        ]);
    }

    private function isWeekLockedForUser(User $user, \DateTimeInterface $date, EntityManagerInterface $em, AccessHelper $access): bool
    {
        // Users with edit access or full access can always see
        if ($access->canEdit('agenda') || $access->isFullAccess('agenda')) {
            return false;
        }

        $weekNum = \App\Service\CalendarHelper::getCustomWeekNumber($date);
        $year = (int) $date->format('Y');
        $magasin = $user->getMagasin();

        if (!$magasin) {
            return false;
        }

        $lock = $em->getRepository(PortalWeekLock::class)->findOneBy([
            'magasin' => $magasin,
            'weekNumber' => $weekNum,
            'year' => $year,
            'isLocked' => true,
        ]);

        return $lock !== null;
    }

    private function isMonthLocked(User $user, \DateTimeInterface $date, EntityManagerInterface $em): bool

    {

        $month = (int)$date->format('m');

        $year = (int)$date->format('Y');



        $validation = $em->getRepository(\App\Entity\PortalMonthlyValidation::class)->findOneBy([

            'user' => $user,

            'month' => $month,

            'year' => $year

        ]);



        return ($validation && $validation->getSignature() !== null);

    }

}





