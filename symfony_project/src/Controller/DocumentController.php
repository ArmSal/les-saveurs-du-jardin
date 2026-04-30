<?php

namespace App\Controller;

use App\Entity\PortalDocument;
use App\Form\PortalDocumentType;
use App\Repository\PortalDocumentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use App\Service\AccessHelper;

#[Route('/documents')]
class DocumentController extends AbstractController
{
    private AccessHelper $access;

    public function __construct(AccessHelper $access)
    {
        $this->access = $access;
    }

    #[Route('/', name: 'app_document_index', methods: ['GET'])]
    public function index(PortalDocumentRepository $documentRepository, \App\Repository\PortalDocumentFolderRepository $folderRepository): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $allDocs    = $documentRepository->findBy(['type' => 'GLOBAL'], ['uploadedAt' => 'DESC']);
        $allFolders = $folderRepository->findBy([], ['name' => 'ASC']);

        $canEdit     = $this->access->canEdit('documents');
        $isFullAccess = $this->access->isFullAccess('documents'); // ACCES_TOTAL only
        $canView     = $this->access->canView('documents');

        // Show add/edit/delete buttons only for editors
        $isAdmin = $canEdit;

        /** @var \App\Entity\User $user */
        $userRoles = $user->getRoles();

        // Helper: is a folder visible to this user?
        // A folder is visible if:
        //  - ACCES_TOTAL user (sees everything), OR
        //  - folder has no rolesPermitted (public), OR
        //  - user has at least one of the folder's rolesPermitted
        $isFolderVisible = function(\App\Entity\PortalDocumentFolder $folder) use ($isFullAccess, $userRoles): bool {
            if ($isFullAccess) return true;
            $permitted = $folder->getRolesPermitted();
            if (empty($permitted)) return true;
            return !empty(array_intersect($userRoles, $permitted));
        };

        // Helper: is a document visible to this user?
        $isDocVisible = function(\App\Entity\PortalDocument $doc) use ($isFullAccess, $userRoles): bool {
            if ($isFullAccess) return true;
            $permitted = $doc->getRolesPermitted();
            if (empty($permitted)) return true;
            return !empty(array_intersect($userRoles, $permitted));
        };

        // Filter documents
        $visibleDocs = [];
        foreach ($allDocs as $doc) {
            if ($isDocVisible($doc)) {
                $visibleDocs[] = $doc;
            }
        }

        // Filter folders (a folder must be visible AND all ancestor folders must be visible)
        // Build a set of visible folder IDs
        $visibleFolderIds = [];
        foreach ($allFolders as $folder) {
            if ($isFolderVisible($folder)) {
                $visibleFolderIds[$folder->getId()] = true;
            }
        }

        // Build folder->docs map (only visible docs)
        $folderDocsMap = [];
        $rootDocs = [];
        foreach ($visibleDocs as $doc) {
            if ($doc->getFolder()) {
                $folderId = $doc->getFolder()->getId();
                // Only show doc if its folder is also visible
                if (isset($visibleFolderIds[$folderId])) {
                    $folderDocsMap[$folderId][] = $doc;
                }
            } else {
                $rootDocs[] = $doc;
            }
        }

        // Root folders = no parent AND visible
        $rootFolders = array_filter($allFolders, fn($f) => $f->getParent() === null && isset($visibleFolderIds[$f->getId()]));

        return $this->render('document/index.html.twig', [
            'folders'          => $allFolders,
            'rootFolders'      => $rootFolders,
            'rootDocs'         => $rootDocs,
            'folderDocsMap'    => $folderDocsMap,
            'isAdmin'          => $isAdmin,
            'visibleFolderIds' => $visibleFolderIds,
        ]);
    }

    private function getFolderPath(?\App\Entity\PortalDocumentFolder $folder): string
    {
        if (!$folder) {
            return '';
        }
        $parentPath = $this->getFolderPath($folder->getParent());
        // Clean folder name for filesystem
        $safeName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $folder->getName());
        return $parentPath . $safeName . '/';
    }

    #[Route('/admin/new', name: 'app_document_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        if (!$this->access->canEdit('documents')) {
            throw $this->createAccessDeniedException('Accès restreint.');
        }

        $document = new PortalDocument();
        $document->setType('GLOBAL'); // IMPORTANT
        $form = $this->createForm(PortalDocumentType::class, $document, ['require_file' => true]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($document->getFolder()) {
                $parentRoles = $document->getFolder()->getRolesPermitted();
                $docRoles = $document->getRolesPermitted();
                $intersected = array_intersect($docRoles, $parentRoles);
                $document->setRolesPermitted(array_values($intersected));
            }

            $file = $form->get('file')->getData();

            if ($file) {
                // Determine folder path
                $subFolder = $this->getFolderPath($document->getFolder());
                $fullTargetDir = $this->getParameter('documents_directory') . '/' . $subFolder;

                if (!is_dir($fullTargetDir)) {
                    mkdir($fullTargetDir, 0777, true);
                }

                $titleToUse = $document->getTitle() ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeTitle = $slugger->slug($titleToUse);
                $newFilename = $safeTitle . '_' . uniqid() . '.' . $file->guessExtension();

                try {
                    $file->move($fullTargetDir, $newFilename);
                    $document->setFilename($subFolder . $newFilename);
                    $document->setOriginalFilename($file->getClientOriginalName());
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du téléchargement du fichier.');
                }
            }

            $entityManager->persist($document);
            $entityManager->flush();

            $this->addFlash('success', 'Document ajouté avec succès.');
            return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('document/new.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/{id}/edit', name: 'app_document_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PortalDocument $document, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        if (!$this->access->canEdit('documents')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(PortalDocumentType::class, $document, ['require_file' => false]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($document->getFolder()) {
                $parentRoles = $document->getFolder()->getRolesPermitted();
                $docRoles = $document->getRolesPermitted();
                $intersected = array_intersect($docRoles, $parentRoles);
                $document->setRolesPermitted(array_values($intersected));
            }

            $file = $form->get('file')->getData();

            if ($file) {
                // Determine folder path
                $subFolder = $this->getFolderPath($document->getFolder());
                $fullTargetDir = $this->getParameter('documents_directory') . '/' . $subFolder;

                if (!is_dir($fullTargetDir)) {
                    mkdir($fullTargetDir, 0777, true);
                }

                $titleToUse = $document->getTitle() ?: pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $safeTitle = $slugger->slug($titleToUse);
                $newFilename = $safeTitle . '_' . uniqid() . '.' . $file->guessExtension();

                try {
                    // Delete old file if exists
                    if ($document->getFilename()) {
                        $oldFilePath = $this->getParameter('documents_directory') . '/' . $document->getFilename();
                        if (file_exists($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }

                    $file->move($fullTargetDir, $newFilename);
                    $document->setFilename($subFolder . $newFilename);
                    $document->setOriginalFilename($file->getClientOriginalName());
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors du téléchargement.');
                }
            }

            $entityManager->flush();
            $this->addFlash('success', 'Document modifié avec succès.');

            return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('document/edit.html.twig', [
            'document' => $document,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/admin/{id}', name: 'app_document_delete', methods: ['POST'])]
    public function delete(Request $request, PortalDocument $document, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('documents')) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete' . $document->getId(), $request->getPayload()->getString('_token'))) {
            if ($document->getFilename()) {
                $filePath = $this->getParameter('documents_directory') . '/' . $document->getFilename();
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }
            $entityManager->remove($document);
            $entityManager->flush();
            $this->addFlash('success', 'Document supprimé avec succès.');
        }

        return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/download/{id}', name: 'app_document_download', methods: ['GET'])]
    public function download(PortalDocument $document): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // Read-only users can view/download but cannot edit
        $canViewModule = $this->access->canView('documents');
        $canEdit = $this->access->canEdit('documents');
        $isFullView = $this->access->isFullView('documents');

        if (!$canViewModule) {
            throw $this->createAccessDeniedException('Vous n\'avez pas accès aux documents.');
        }

        // If user has full view or edit access, they can download any document
        // Otherwise, check role-based visibility on the specific document
        if (!$canEdit && !$isFullView) {
            if (empty(array_intersect($user->getRoles(), $document->getRolesPermitted()))) {
                throw $this->createAccessDeniedException('Vous n\'avez pas accès à ce document.');
            }
        }

        $filePath = $this->getParameter('documents_directory') . '/' . $document->getFilename();

        if (!file_exists($filePath)) {
            $this->addFlash('error', 'Fichier introuvable sur le serveur.');
            return $this->redirectToRoute('app_document_index');
        }

        $response = new BinaryFileResponse($filePath);
        $response->setContentDisposition(
            ResponseHeaderBag::DISPOSITION_INLINE,
            $document->getOriginalFilename()
        );

        return $response;
    }
}


