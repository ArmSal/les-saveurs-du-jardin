<?php

namespace App\Controller;

use App\Entity\PortalProduct;
use App\Entity\PortalCategorieProduit;
use App\Entity\PortalNotification;
use App\Entity\User;
use App\Form\PortalCategorieProduitType;
use App\Form\PortalProductType;
use App\Repository\PortalCategorieProduitRepository;
use App\Repository\PortalProductRepository;
use App\Service\AccessHelper;
use Doctrine\DBAL\Exception\ForeignKeyConstraintViolationException;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/produits')]
class ProduitController extends AbstractController
{
    private AccessHelper $access;

    public function __construct(AccessHelper $access)
    {
        $this->access = $access;
    }

    #[Route('', name: 'app_produit_index', methods: ['GET'])]
    public function index(Request $request, PortalProductRepository $productRepo, PaginatorInterface $paginator, EntityManagerInterface $em): Response
    {
        if (!$this->access->canView('produits')) {
            throw $this->createAccessDeniedException();
        }

        $searchTerm = $request->query->get('q');
        $categoryFilter = $request->query->get('category');
        $sortBy = $request->query->get('sortBy', 'designation');
        $allowedSorts = ['categoryEntity', 'designation', 'reference', 'code_barre', 'prix', 'qte_stock'];

        $sortField = in_array($sortBy, $allowedSorts) ? $sortBy : 'designation';
        
        $queryBuilder = $productRepo->createQueryBuilder('p');

        if ($searchTerm) {
            $queryBuilder->andWhere('p.designation LIKE :q OR p.reference LIKE :q OR p.code_barre LIKE :q')
                ->setParameter('q', '%' . $searchTerm . '%');
        }

        if ($categoryFilter && $categoryFilter !== 'all') {
            $queryBuilder->andWhere('p.categoryEntity = :catId')
                ->setParameter('catId', $categoryFilter);
        }

        $queryBuilder->orderBy('p.' . $sortField, 'ASC');

        // Categories for filter
        $categoryList = $em->getRepository(PortalCategorieProduit::class)->findAllOrderByName();

        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            20
        );

        return $this->render('produit/index.html.twig', [
            'produits' => $pagination,
            'categories' => $categoryList,
            'currentCategory' => $categoryFilter ?: 'all',
            'searchTerm' => $searchTerm,
            'currentSort' => $sortBy,
            'canEdit' => $this->access->canEdit('produits'),
            'notifications' => $em->getRepository(PortalNotification::class)->findLatestForUser($this->getUser(), 5),
            'unreadNotificationsCount' => $em->getRepository(PortalNotification::class)->countUnreadForUser($this->getUser()),
        ]);
    }

    #[Route('/new', name: 'app_produit_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        if (!$this->access->canEdit('produits')) {
            throw $this->createAccessDeniedException();
        }

        $product = new PortalProduct();
        $form = $this->createForm(PortalProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image_file')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move($this->getParameter('products_directory'), $newFilename);
                    $product->setImageUrl($newFilename);
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Erreur upload: ' . $e->getMessage());
                }
            }

            $entityManager->persist($product);
            
            // Notification
            $allUsers = $entityManager->getRepository(User::class)->findAll();
            foreach ($allUsers as $u) {
                $notif = new PortalNotification();
                $notif->setUser($u);
                $notif->setTitle('Nouveau Produit');
                $notif->setContent(sprintf('Le produit "%s" est disponible.', $product->getDesignation()));
                $notif->setLink('/produits');
                $notif->setType('NEW_PRODUCT');
                $entityManager->persist($notif);
            }

            $entityManager->flush();
            $this->addFlash('success', 'Produit ajouté avec succès.');
            return $this->redirectToRoute('app_produit_index');
        }

        return $this->render('produit/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/edit', name: 'app_produit_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PortalProduct $product, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        if (!$this->access->canEdit('produits')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(PortalProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('image_file')->getData();
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename . '-' . uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move($this->getParameter('products_directory'), $newFilename);
                    $product->setImageUrl($newFilename);
                } catch (\Exception $e) {
                    $this->addFlash('error', 'Erreur upload: ' . $e->getMessage());
                }
            }

            $entityManager->flush();
            $this->addFlash('success', 'Produit mis à jour.');
            return $this->redirectToRoute('app_produit_index');
        }

        return $this->render('produit/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}/delete', name: 'app_produit_delete', methods: ['POST'])]
    public function delete(Request $request, PortalProduct $product, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('produits')) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete' . $product->getId(), $request->request->get('_token'))) {
            try {
                // Delete the product image file if it exists
                $imageUrl = $product->getImageUrl();
                if ($imageUrl) {
                    $imagePath = $this->getParameter('products_directory') . '/' . $imageUrl;
                    if (file_exists($imagePath)) {
                        unlink($imagePath);
                    }
                }

                $entityManager->remove($product);
                $entityManager->flush();
                $this->addFlash('success', 'Produit supprimé.');
            } catch (ForeignKeyConstraintViolationException $e) {
                $this->addFlash('error', 'Impossible de supprimer ce produit : il est déjà lié à des commandes.');
            } catch (\Exception $e) {
                $this->addFlash('error', 'Erreur lors de la suppression du produit.');
            }
        }

        return $this->redirectToRoute('app_produit_index');
    }

    #[Route('/{id}', name: 'app_produit_show', methods: ['GET'])]
    public function show(PortalProduct $produit): Response
    {
        if (!$this->access->canView('produits')) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
            'canEdit' => $this->access->canEdit('produits'),
        ]);
    }

    #[Route('/categories', name: 'app_produit_category_index', methods: ['GET'], priority: 2)]
    public function categoryIndex(PortalCategorieProduitRepository $categoryRepo): Response
    {
        if (!$this->access->canEdit('produits')) {
            throw $this->createAccessDeniedException();
        }

        return $this->render('produit/categories/index.html.twig', [
            'categories' => $categoryRepo->findAllOrderByName(),
        ]);
    }

    #[Route('/categories/new', name: 'app_produit_category_new', methods: ['GET', 'POST'], priority: 2)]
    public function categoryNew(Request $request, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('produits')) {
            throw $this->createAccessDeniedException();
        }

        $category = new PortalCategorieProduit();
        $form = $this->createForm(PortalCategorieProduitType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash('success', 'Catégorie ajoutée.');
            return $this->redirectToRoute('app_produit_category_index');
        }

        return $this->render('produit/categories/new.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/categories/{id}/edit', name: 'app_produit_category_edit', methods: ['GET', 'POST'], priority: 2)]
    public function categoryEdit(Request $request, PortalCategorieProduit $category, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('produits')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(PortalCategorieProduitType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Catégorie mise à jour.');
            return $this->redirectToRoute('app_produit_category_index');
        }

        return $this->render('produit/categories/edit.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/categories/{id}/delete', name: 'app_produit_category_delete', methods: ['POST'], priority: 2)]
    public function categoryDelete(Request $request, PortalCategorieProduit $category, EntityManagerInterface $entityManager): Response
    {
        if (!$this->access->canEdit('produits')) {
            throw $this->createAccessDeniedException();
        }

        if ($this->isCsrfTokenValid('delete' . $category->getId(), $request->request->get('_token'))) {
            // Check if products are still linked
            if ($category->getProducts()->count() > 0) {
                $this->addFlash('error', 'Impossible de supprimer une catégorie liée à des produits.');
            } else {
                $entityManager->remove($category);
                $entityManager->flush();
                $this->addFlash('success', 'Catégorie supprimée.');
            }
        }

        return $this->redirectToRoute('app_produit_category_index');
    }
}

