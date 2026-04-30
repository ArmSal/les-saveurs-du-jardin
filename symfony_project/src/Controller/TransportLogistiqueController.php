<?php

namespace App\Controller;

use App\Entity\TransEtLog;
use App\Entity\TransEtLogCamion;
use App\Form\TransEtLogType;
use App\Form\TransEtLogCamionType;
use App\Repository\TransEtLogRepository;
use App\Repository\TransEtLogCamionRepository;
use App\Repository\MagasinRepository;
use App\Service\AccessHelper;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

#[Route('/transport-logistique')]
class TransportLogistiqueController extends AbstractController
{
    private AccessHelper $access;

    public function __construct(AccessHelper $access)
    {
        $this->access = $access;
    }

    #[Route('', name: 'app_transport_logistique', methods: ['GET'])]
    public function index(
        Request $request,
        TransEtLogRepository $tourRepo,
        TransEtLogCamionRepository $camionRepo,
        MagasinRepository $magasinRepo,
        PaginatorInterface $paginator
    ): Response {
        if (!$this->access->canView('transport_logistique')) {
            throw $this->createAccessDeniedException();
        }

        $dateFrom = $request->query->get('dateFrom') ? new \DateTime($request->query->get('dateFrom')) : null;
        $dateTo = $request->query->get('dateTo') ? new \DateTime($request->query->get('dateTo')) : null;
        $camionId = $request->query->get('camion') ? (int) $request->query->get('camion') : null;
        $magasinId = $request->query->get('magasin') ? (int) $request->query->get('magasin') : null;

        $queryBuilder = $tourRepo->createQueryBuilder('t')
            ->leftJoin('t.camion', 'c')
            ->leftJoin('t.magasins', 'm')
            ->addSelect('c', 'm');

        if ($dateFrom) {
            $queryBuilder->andWhere('t.date >= :dateFrom')
                ->setParameter('dateFrom', $dateFrom);
        }

        if ($dateTo) {
            $queryBuilder->andWhere('t.date <= :dateTo')
                ->setParameter('dateTo', $dateTo);
        }

        if ($camionId) {
            $queryBuilder->andWhere('c.id = :camionId')
                ->setParameter('camionId', $camionId);
        }

        if ($magasinId) {
            $queryBuilder->andWhere('m.id = :magasinId')
                ->setParameter('magasinId', $magasinId);
        }

        $queryBuilder->orderBy('t.date', 'DESC');

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('transport_logistique/index.html.twig', [
            'tours' => $pagination,
            'camions' => $camionRepo->findAllActive(),
            'magasins' => $magasinRepo->findBy(['isActive' => true], ['nom' => 'ASC']),
            'dateFrom' => $dateFrom?->format('Y-m-d'),
            'dateTo' => $dateTo?->format('Y-m-d'),
            'currentCamion' => $camionId,
            'currentMagasin' => $magasinId,
            'canEdit' => $this->access->canEdit('transport_logistique'),
        ]);
    }

    #[Route('/new', name: 'app_transport_logistique_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('transport_logistique')) {
            throw $this->createAccessDeniedException();
        }

        $tour = new TransEtLog();
        $tour->setDate(new \DateTime());

        $form = $this->createForm(TransEtLogType::class, $tour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($tour);
            $entityManager->flush();

            $this->addFlash('success', 'Tournée ajoutée avec succès.');
            return $this->redirectToRoute('app_transport_logistique');
        }

        return $this->render('transport_logistique/new.html.twig', [
            'tour' => $tour,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_transport_logistique_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, TransEtLog $tour, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('transport_logistique')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(TransEtLogType::class, $tour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Tournée mise à jour avec succès.');
            return $this->redirectToRoute('app_transport_logistique');
        }

        return $this->render('transport_logistique/edit.html.twig', [
            'tour' => $tour,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_transport_logistique_delete', methods: ['POST'])]
    public function delete(Request $request, TransEtLog $tour, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('transport_logistique')) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete' . $tour->getId(), $request->request->get('_token'))) {
            $entityManager->remove($tour);
            $entityManager->flush();
            $this->addFlash('success', 'Tournée supprimée.');
        }

        return $this->redirectToRoute('app_transport_logistique');
    }

    #[Route('/report', name: 'app_transport_logistique_report', methods: ['GET'])]
    public function reportPdf(
        Request $request,
        TransEtLogRepository $tourRepo,
        TransEtLogCamionRepository $camionRepo
    ): Response {
        if (!$this->access->canView('transport_logistique')) {
            throw $this->createAccessDeniedException();
        }

        $month = $request->query->getInt('mois');
        $year = $request->query->getInt('annee');
        $camionId = $request->query->getInt('camion');

        if (!$month || !$year || !$camionId) {
            $this->addFlash('error', 'Veuillez sélectionner un mois, une année et un camion.');
            return $this->redirectToRoute('app_transport_logistique');
        }

        $camion = $camionRepo->find($camionId);
        if (!$camion) {
            throw $this->createNotFoundException('Camion introuvable.');
        }

        // Calculate date range for the month
        $dateFrom = new \DateTime(sprintf('%04d-%02d-01', $year, $month));
        $dateTo = clone $dateFrom;
        $dateTo->modify('last day of this month')->setTime(23, 59, 59);

        $queryBuilder = $tourRepo->createQueryBuilder('t')
            ->leftJoin('t.magasins', 'm')
            ->addSelect('m')
            ->andWhere('t.camion = :camion')
            ->setParameter('camion', $camion)
            ->andWhere('t.date >= :dateFrom')
            ->setParameter('dateFrom', $dateFrom)
            ->andWhere('t.date <= :dateTo')
            ->setParameter('dateTo', $dateTo)
            ->orderBy('t.date', 'ASC');

        $tours = $queryBuilder->getQuery()->getResult();

        $html = $this->renderView('transport_logistique/report_pdf.html.twig', [
            'camion' => $camion,
            'tours' => $tours,
            'mois' => $month,
            'annee' => $year,
        ]);

        $options = new Options();
        $options->set('defaultFont', 'Arial');
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return new Response(
            $dompdf->output(),
            Response::HTTP_OK,
            [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => sprintf('inline; filename="rapport_tournees_%04d_%02d.pdf"', $year, $month)
            ]
        );
    }

    // Camion Management Routes

    #[Route('/camions', name: 'app_transport_logistique_camion_index', methods: ['GET'])]
    public function camionIndex(TransEtLogCamionRepository $camionRepo): Response
    {
        if (!$this->access->canView('transport_logistique')) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('transport_logistique/camions/index.html.twig', [
            'camions' => $camionRepo->findAllOrderByName(),
            'canEdit' => $this->access->canEdit('transport_logistique'),
        ]);
    }

    #[Route('/camions/new', name: 'app_transport_logistique_camion_new', methods: ['GET', 'POST'])]
    public function camionNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('transport_logistique')) {
            throw $this->createAccessDeniedException();
        }

        $camion = new TransEtLogCamion();
        $camion->setIsActive(true);

        $form = $this->createForm(TransEtLogCamionType::class, $camion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($camion);
            $entityManager->flush();

            $this->addFlash('success', 'Camion ajouté avec succès.');
            return $this->redirectToRoute('app_transport_logistique_camion_index');
        }

        return $this->render('transport_logistique/camions/new.html.twig', [
            'camion' => $camion,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/camions/{id}/edit', name: 'app_transport_logistique_camion_edit', methods: ['GET', 'POST'])]
    public function camionEdit(Request $request, TransEtLogCamion $camion, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('transport_logistique')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(TransEtLogCamionType::class, $camion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Camion mis à jour avec succès.');
            return $this->redirectToRoute('app_transport_logistique_camion_index');
        }

        return $this->render('transport_logistique/camions/edit.html.twig', [
            'camion' => $camion,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/camions/{id}/delete', name: 'app_transport_logistique_camion_delete', methods: ['GET'])]
    public function camionDelete(Request $request, TransEtLogCamion $camion, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('transport_logistique')) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete_camion' . $camion->getId(), $request->query->get('_token'))) {
            try {
                $entityManager->remove($camion);
                $entityManager->flush();
                $this->addFlash('success', 'Camion supprimé.');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Impossible de supprimer ce camion : il est lié à des tournées.');
            }
        }

        return $this->redirectToRoute('app_transport_logistique_camion_index');
    }
}
