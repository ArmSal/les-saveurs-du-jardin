<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class MediaController extends AbstractController
{
    #[Route('/media/user/{filename}', name: 'app_media_user')]
    public function serveUserPhoto(string $filename): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $filePath = $this->getParameter('users_directory') . '/' . $filename;

        if (!file_exists($filePath)) {
            // Return a default transparent pixel or a placeholder if file not found
            throw $this->createNotFoundException('Photo non trouvée.');
        }

        return new BinaryFileResponse($filePath);
    }

    #[Route('/media/product/{filename}', name: 'app_media_product')]
    public function serveProductImage(string $filename): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $filePath = $this->getParameter('products_directory') . '/' . $filename;

        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('Image produit non trouvée.');
        }
        return new BinaryFileResponse($filePath);
    }

    #[Route('/media/shortcut/{filename}', name: 'app_media_shortcut')]
    public function serveShortcutIcon(string $filename): Response
    {
        // Shortcuts are public-facing enough, but we should still require auth if possible
        // $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $filePath = $this->getParameter('shortcuts_directory') . '/' . $filename;

        if (!file_exists($filePath)) {
            throw $this->createNotFoundException('Icône non trouvée.');
        }

        return new BinaryFileResponse($filePath);
    }
}


