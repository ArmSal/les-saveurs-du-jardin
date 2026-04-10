<?php

namespace App\Controller\Admin;

use App\Entity\PortalShortcut;
use App\Repository\PortalShortcutRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use App\Service\AccessHelper;

#[Route('/admin/shortcuts')]
class ShortcutController extends AbstractController
{
    private AccessHelper $access;

    public function __construct(AccessHelper $access)
    {
        $this->access = $access;
    }

    #[Route('/', name: 'admin_shortcuts_index')]
    public function index(PortalShortcutRepository $repository): Response
    {
        if (!$this->access->canView('shortcuts')) {
            throw $this->createAccessDeniedException();
        }
        $shortcuts = $repository->findAllOrdered();
        $takenOrders = array_map(fn($s) => $s->getDisplayOrder(), $shortcuts);
        
        return $this->render('admin/shortcut/index.html.twig', [
            'shortcuts' => $shortcuts,
            'takenOrders' => $takenOrders,
        ]);
    }

    #[Route('/new', name: 'admin_shortcuts_new', methods: ['POST'])]
    public function new(Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        if (!$this->access->canEdit('shortcuts')) {
            throw $this->createAccessDeniedException();
        }
        
        $shortcut = new PortalShortcut();
        $shortcut->setLabel($request->request->get('label'));
        $shortcut->setUrl($request->request->get('url'));
        $shortcut->setColorClass($request->request->get('colorClass', 'text-slate-600'));
        $shortcut->setDisplayOrder((int) $request->request->get('displayOrder', 0));

        // Handle File or SVG
        $iconFile = $request->files->get('iconFile');
        $iconText = $request->request->get('icon');

        if ($iconFile) {
            $originalFilename = pathinfo($iconFile->getClientOriginalName(), PATHINFO_FILENAME);
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename = $safeFilename . '-' . uniqid() . '.' . $iconFile->guessExtension();

            try {
                $iconFile->move(
                    $this->getParameter('shortcuts_directory'),
                    $newFilename
                );
                $shortcut->setIcon($newFilename);
            } catch (FileException $e) {
                $this->addFlash('error', 'Erreur lors de l\'upload de l\'icône.');
            }
        } elseif ($iconText) {
            $shortcut->setIcon($iconText);
        } else {
            $shortcut->setIcon(null); // Default icon logic in template
        }

        $em->persist($shortcut);
        $em->flush();

        return $this->redirectToRoute('admin_shortcuts_index');
    }

    #[Route('/edit/{id}', name: 'admin_shortcuts_edit', methods: ['GET', 'POST'])]
    public function edit(PortalShortcut $shortcut, Request $request, EntityManagerInterface $em, SluggerInterface $slugger): Response
    {
        if (!$this->access->canEdit('shortcuts')) {
            throw $this->createAccessDeniedException();
        }
        
        if ($request->isMethod('POST')) {
            $shortcut->setLabel($request->request->get('label'));
            $shortcut->setUrl($request->request->get('url'));
            $shortcut->setColorClass($request->request->get('colorClass'));
            $shortcut->setDisplayOrder((int) $request->request->get('displayOrder'));

            // Handle File or SVG
            $iconFile = $request->files->get('iconFile');
            $iconText = $request->request->get('icon');

            if ($iconFile) {
                // Delete old file if exists
                if ($shortcut->getIcon() && !str_starts_with($shortcut->getIcon(), '<svg') && !str_starts_with($shortcut->getIcon(), 'http')) {
                    $oldFile = $this->getParameter('shortcuts_directory') . '/' . $shortcut->getIcon();
                    if (file_exists($oldFile)) @unlink($oldFile);
                }

                $originalFilename = pathinfo($iconFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $iconFile->guessExtension();

                try {
                    $iconFile->move($this->getParameter('shortcuts_directory'), $newFilename);
                    $shortcut->setIcon($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('error', 'Erreur lors de l\'upload.');
                    $shortcut->setIcon($iconText ?: null);
                }
            } else {
                $shortcut->setIcon($iconText ?: null);
            }

            $em->flush();
            return $this->redirectToRoute('admin_shortcuts_index');
        }

        return $this->render('admin/shortcut/edit.html.twig', [
            'shortcut' => $shortcut,
        ]);
    }

    #[Route('/delete/{id}', name: 'admin_shortcuts_delete', methods: ['POST'])]
    public function delete(PortalShortcut $shortcut, EntityManagerInterface $em): Response
    {
        if (!$this->access->canEdit('shortcuts')) {
            throw $this->createAccessDeniedException();
        }
        
        // Delete physical file if it was an upload
        if ($shortcut->getIcon() && !str_starts_with($shortcut->getIcon(), '<svg') && !str_starts_with($shortcut->getIcon(), 'http')) {
            $filePath = $this->getParameter('shortcuts_directory') . '/' . $shortcut->getIcon();
            if (file_exists($filePath)) @unlink($filePath);
        }

        $em->remove($shortcut);
        $em->flush();

        return $this->redirectToRoute('admin_shortcuts_index');
    }
}


