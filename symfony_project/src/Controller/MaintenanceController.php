<?php

namespace App\Controller;

use App\Entity\CleaningTask;
use App\Entity\CleaningTaskItem;
use App\Entity\User;
use App\Form\CleaningTaskType;
use App\Repository\CleaningTaskRepository;
use App\Repository\MagasinRepository;
use App\Repository\UserRepository;
use App\Service\AccessHelper;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/maintenance')]
class MaintenanceController extends AbstractController
{
    private AccessHelper $access;

    public function __construct(AccessHelper $access)
    {
        $this->access = $access;
    }

    #[Route('/signalement', name: 'app_maintenance_signalement', methods: ['GET'])]
    public function signalement(): Response
    {
        if (!$this->access->canView('maintenance_signalement')) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('static/placeholder.html.twig', [
            'title' => 'Signalement matériel',
            'description' => 'Cette fonctionnalité sera bientôt disponible.'
        ]);
    }

    #[Route('/suivi', name: 'app_maintenance_suivi', methods: ['GET'])]
    public function suivi(
        Request $request,
        CleaningTaskRepository $taskRepo,
        MagasinRepository $magasinRepo,
        UserRepository $userRepo,
        PaginatorInterface $paginator
    ): Response {
        if (!$this->access->canView('maintenance_suivi')) {
            throw $this->createAccessDeniedException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $isFullAccess = $this->access->isFullAccess('maintenance_suivi');
        $isPersonalAccess = $this->access->isPersonalAccess('maintenance_suivi');

        $dateFrom = $request->query->get('dateFrom') ? new \DateTime($request->query->get('dateFrom')) : null;
        $dateTo = $request->query->get('dateTo') ? new \DateTime($request->query->get('dateTo')) : null;
        $magasinId = $request->query->get('magasin') ? (int) $request->query->get('magasin') : null;
        $userId = $request->query->get('user') ? (int) $request->query->get('user') : null;

        $queryBuilder = $taskRepo->createQueryBuilder('ct')
            ->leftJoin('ct.magasin', 'm')
            ->leftJoin('ct.user', 'u')
            ->addSelect('m', 'u')
            ->orderBy('ct.date', 'DESC');

        if (!$isFullAccess) {
            $queryBuilder->andWhere('ct.user = :currentUser')
                ->setParameter('currentUser', $currentUser);
        } elseif ($userId) {
            $queryBuilder->andWhere('u.id = :userId')
                ->setParameter('userId', $userId);
        }

        if ($dateFrom) {
            $queryBuilder->andWhere('ct.date >= :dateFrom')
                ->setParameter('dateFrom', $dateFrom);
        }

        if ($dateTo) {
            $queryBuilder->andWhere('ct.date <= :dateTo')
                ->setParameter('dateTo', $dateTo);
        }

        if ($magasinId) {
            $queryBuilder->andWhere('m.id = :magasinId')
                ->setParameter('magasinId', $magasinId);
        }

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('maintenance/suivi/index.html.twig', [
            'tasks' => $pagination,
            'magasins' => $magasinRepo->findBy(['isActive' => true], ['nom' => 'ASC']),
            'users' => $isFullAccess ? $userRepo->findAll() : [],
            'dateFrom' => $dateFrom?->format('Y-m-d'),
            'dateTo' => $dateTo?->format('Y-m-d'),
            'currentMagasin' => $magasinId,
            'currentUser' => $userId,
            'isFullAccess' => $isFullAccess,
            'isPersonalAccess' => $isPersonalAccess,
            'canEdit' => $this->access->canEdit('maintenance_suivi') || $isPersonalAccess,
        ]);
    }

    #[Route('/suivi/new', name: 'app_maintenance_suivi_new', methods: ['GET', 'POST'])]
    public function suiviNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        // ACCES_TOTAL or ACCES_PERSONNEL can create new forms
        if (!$this->access->canEdit('maintenance_suivi') && !$this->access->isPersonalAccess('maintenance_suivi')) {
            throw $this->createAccessDeniedException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();

        $task = new CleaningTask();
        $task->setUser($currentUser);
        $task->setDate(new \DateTime());

        // Add one empty item by default
        $item = new CleaningTaskItem();
        $task->addItem($item);

        $form = $this->createForm(CleaningTaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($task);
            $entityManager->flush();

            $this->addFlash('success', 'Fiche de nettoyage créée avec succès.');
            return $this->redirectToRoute('app_maintenance_suivi');
        }

        return $this->render('maintenance/suivi/new.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/suivi/{id}', name: 'app_maintenance_suivi_show', methods: ['GET'])]
    public function suiviShow(CleaningTask $task): Response
    {
        if (!$this->access->canView('maintenance_suivi')) {
            throw $this->createAccessDeniedException();
        }

        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $isFullAccess = $this->access->isFullAccess('maintenance_suivi');

        // Check permissions
        if (!$isFullAccess && $task->getUser() !== $currentUser) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('maintenance/suivi/show.html.twig', [
            'task' => $task,
            'isFullAccess' => $isFullAccess,
            'isPersonalAccess' => $this->access->isPersonalAccess('maintenance_suivi'),
        ]);
    }

    #[Route('/suivi/{id}/edit', name: 'app_maintenance_suivi_edit', methods: ['GET', 'POST'])]
    public function suiviEdit(Request $request, CleaningTask $task, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $isFullAccess = $this->access->isFullAccess('maintenance_suivi');
        $isPersonalAccess = $this->access->isPersonalAccess('maintenance_suivi');

        // Check permissions - must have edit access and own the task (unless full access)
        if (!$isFullAccess && !$isPersonalAccess) {
            throw $this->createAccessDeniedException();
        }

        // For personal access, can only edit own forms
        if ($isPersonalAccess && $task->getUser() !== $currentUser) {
            throw $this->createAccessDeniedException();
        }

        // Personal access cannot edit approved forms
        $isReadOnly = ($task->isApproved() && !$isFullAccess) || ($isPersonalAccess && $task->isApproved());

        $form = $this->createForm(CleaningTaskType::class, $task, [
            'is_read_only' => $isReadOnly,
        ]);
        $form->handleRequest($request);

        if (!$isReadOnly && $form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            $this->addFlash('success', 'Fiche de nettoyage mise à jour.');
            return $this->redirectToRoute('app_maintenance_suivi');
        }

        return $this->render('maintenance/suivi/edit.html.twig', [
            'task' => $task,
            'form' => $form->createView(),
            'isReadOnly' => $isReadOnly,
            'isFullAccess' => $isFullAccess,
            'isPersonalAccess' => $isPersonalAccess,
        ]);
    }

    #[Route('/suivi/{id}/approve', name: 'app_maintenance_suivi_approve', methods: ['GET'])]
    public function suiviApprove(Request $request, CleaningTask $task, EntityManagerInterface $entityManager): Response
    {
        // Only ACCES_TOTAL can approve forms
        if (!$this->access->isFullAccess('maintenance_suivi')) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('approve' . $task->getId(), $request->query->get('_token'))) {
            $task->setIsApproved(true);
            $entityManager->flush();
            $this->addFlash('success', 'Fiche approuvée et verrouillée.');
        }

        return $this->redirectToRoute('app_maintenance_suivi');
    }

    #[Route('/suivi/{id}/delete', name: 'app_maintenance_suivi_delete', methods: ['GET'])]
    public function suiviDelete(Request $request, CleaningTask $task, EntityManagerInterface $entityManager): Response
    {
        /** @var User $currentUser */
        $currentUser = $this->getUser();
        $isFullAccess = $this->access->isFullAccess('maintenance_suivi');
        $isPersonalAccess = $this->access->isPersonalAccess('maintenance_suivi');

        // Check permissions
        if (!$isFullAccess && !$isPersonalAccess) {
            throw $this->createAccessDeniedException();
        }

        // Can only delete own tasks (unless full access)
        if (!$isFullAccess && $task->getUser() !== $currentUser) {
            throw $this->createAccessDeniedException();
        }

        // Personal access cannot delete approved forms
        if ($task->isApproved() && !$isFullAccess) {
            $this->addFlash('error', 'Impossible de supprimer une fiche approuvée.');
            return $this->redirectToRoute('app_maintenance_suivi');
        }

        if ($this->isCsrfTokenValid('delete' . $task->getId(), $request->query->get('_token'))) {
            $entityManager->remove($task);
            $entityManager->flush();
            $this->addFlash('success', 'Fiche supprimée.');
        }

        return $this->redirectToRoute('app_maintenance_suivi');
    }
}
