<?php

namespace App\Controller;

use App\Entity\PortalDocumentFolder;
use App\Form\PortalDocumentFolderType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\AccessHelper;

#[Route('/admin/document-folder')]
class DocumentFolderController extends AbstractController
{
    private AccessHelper $access;

    public function __construct(AccessHelper $access)
    {
        $this->access = $access;
    }

    #[Route('/new', name: 'app_document_folder_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('documents')) {
            throw $this->createAccessDeniedException();
        }

        $folder = new PortalDocumentFolder();
        $form = $this->createForm(PortalDocumentFolderType::class, $folder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($folder->getParent()) {
                $parentRoles = $folder->getParent()->getRolesPermitted();
                $folderRoles = $folder->getRolesPermitted();
                $intersected = array_intersect($folderRoles, $parentRoles);
                $folder->setRolesPermitted(array_values($intersected));
            }

            $entityManager->persist($folder);
            $entityManager->flush();

            $this->addFlash('success', 'Dossier créé avec succès.');

            return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('document_folder/new.html.twig', [
            'folder' => $folder,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_document_folder_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PortalDocumentFolder $folder, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('documents')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(PortalDocumentFolderType::class, $folder);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($folder->getParent()) {
                $parentRoles = $folder->getParent()->getRolesPermitted();
                $folderRoles = $folder->getRolesPermitted();
                $intersected = array_intersect($folderRoles, $parentRoles);
                $folder->setRolesPermitted(array_values($intersected));
            }

            $entityManager->flush();
            $this->addFlash('success', 'Dossier modifié avec succès.');

            return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('document_folder/edit.html.twig', [
            'folder' => $folder,
            'form' => $form->createView(),
        ]);
    }

    private function getFolderPath(?PortalDocumentFolder $folder): string
    {
        if (!$folder) {
            return '';
        }
        $parentPath = $this->getFolderPath($folder->getParent());
        $safeName = str_replace(['/', '\\', ':', '*', '?', '"', '<', '>', '|'], '_', $folder->getName());
        return $parentPath . $safeName . '/';
    }

    #[Route('/{id}', name: 'app_document_folder_delete', methods: ['POST', 'DELETE'])]
    public function delete(Request $request, PortalDocumentFolder $folder, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('documents')) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete' . $folder->getId(), $request->request->get('_token'))) {
            // Build the physical path BEFORE removing the entity
            $folderRelativePath = $this->getFolderPath($folder);
            $fullPath = $this->getParameter('documents_directory') . '/' . $folderRelativePath;

            // Physical deletion: remove folder and all its contents
            if (!empty($folderRelativePath) && is_dir($fullPath)) {
                $this->removeDirectory($fullPath);
            }

            $entityManager->remove($folder);
            $entityManager->flush();
            $this->addFlash('success', 'Dossier et tout son contenu physique ont été supprimés avec succès.');
        }

        return $this->redirectToRoute('app_document_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Recursively remove a directory
     */
    private function removeDirectory(string $dir): void
    {
        if (!is_dir($dir)) return;
        
        $it = new \RecursiveDirectoryIterator($dir, \RecursiveDirectoryIterator::SKIP_DOTS);
        $files = new \RecursiveIteratorIterator($it, \RecursiveIteratorIterator::CHILD_FIRST);
        
        foreach ($files as $file) {
            if ($file->isDir()) {
                rmdir($file->getRealPath());
            } else {
                unlink($file->getRealPath());
            }
        }
        rmdir($dir);
    }
}


