<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Service\GooglePlacesService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class StaticPageController extends AbstractController
{
    /**
     * Place IDs sourced from the Google Maps embed URLs.
     * To verify/update: open google.com/maps, find the store, click Share → Embed, copy the Place ID.
     */
    private const PLACE_IDS = [
        'Olivet'       => 'ChIJyaFP5SVl5EcRy1eQm7k2lrs',
        'St Gervais'   => 'ChIJFfhYBUevA0gRGxbVkpXMiGg',
        'Villemandeur' => 'ChIJkXJy4bkW5UcRZ2eKiAOvVn4',
        'Saran'        => 'ChIJp0K0LotY5EcRqFBetLDjpxk',
        'Noyers'       => 'ChIJPyDYFuqR9EcRNKqiLDfFjcA',
    ];

    private function getGoogleData(GooglePlacesService $gps, string $magasin): array
    {
        $placeId = self::PLACE_IDS[$magasin] ?? null;
        $live    = $placeId ? $gps->getPlaceDetails($placeId) : null;
        return [
            'google_rating'       => $live['rating'] ?? null,
            'google_review_count' => $live['user_ratings_total'] ?? null,
        ];
    }

    #[Route('/contact/olivet', name: 'app_contact_olivet')]
    public function olivet(UserRepository $userRepo, GooglePlacesService $gps): Response
    {
        $directeurs = $userRepo->findByRole('ROLE_DIRECTEUR');
        $managers = $userRepo->createQueryBuilder('u')
            ->join('u.roleEntity', 'r')
            ->where('u.magasin = :mag')
            ->andWhere('r.isContact = true')
            ->setParameter('mag', 'Olivet')
            ->getQuery()
            ->getResult();

        return $this->render('static/olivet.html.twig', [
            'magasin_name' => 'Les Saveurs du Jardin - Olivet',
            'address' => '1410 Rue de la Bergeresse, 45160 Olivet',
            'phone' => '09 81 10 23 29',
            'instagram' => 'https://www.instagram.com/les_saveurs_du_jardin/',
            'hours' => [
                'Lundi' => '09h00 – 19h30',
                'Mardi' => '09h00 – 19h30',
                'Mercredi' => '09h00 – 19h30',
                'Jeudi' => '09h00 – 19h30',
                'Vendredi' => '09h00 – 19h30',
                'Samedi' => '09h00 – 19h30',
                'Dimanche' => '09h00 – 12h30',
            ],
            'email'       => 'contac@lessaveursdujardin.fr',
            'directeurs'  => $directeurs,
            'managers'    => $managers,
            'google_reviews_url'       => 'https://www.google.com/maps/place/Les+Saveurs+du+Jardin/@47.845475,1.918422,17z/data=!4m8!3m7!1s0x47e4e525e5afa1c9:0xbb9636b9939057cb!8m2!3d47.845475!4d1.918422!9m1!1b1',
            'google_write_review_url'  => 'https://search.google.com/local/writereview?placeid=' . self::PLACE_IDS['Olivet'],
        ] + $this->getGoogleData($gps, 'Olivet'));
    }

    #[Route('/contact/st-gervais', name: 'app_contact_st_gervais')]
    public function stGervais(UserRepository $userRepo, GooglePlacesService $gps): Response
    {
        $directeurs = $userRepo->findByRole('ROLE_DIRECTEUR');
        $managers = $userRepo->createQueryBuilder('u')
            ->join('u.roleEntity', 'r')
            ->where('u.magasin = :mag')
            ->andWhere('r.isContact = true')
            ->setParameter('mag', 'St Gervais')
            ->getQuery()
            ->getResult();

        return $this->render('static/st_gervais.html.twig', [
            'magasin_name' => 'Les Saveurs du Jardin - St Gervais',
            'address' => '113B Rte Nationale, 41350 Saint-Gervais-la-Forêt',
            'phone' => '02 54 87 90 69',
            'instagram' => 'https://www.instagram.com/les_saveurs_du_jardin/',
            'hours' => [
                'Lundi' => '09h00 – 19h00',
                'Mardi' => '09h00 – 19h00',
                'Mercredi' => '09h00 – 19h00',
                'Jeudi' => '09h00 – 19h00',
                'Vendredi' => '09h00 – 19h00',
                'Samedi' => '09h00 – 19h00',
                'Dimanche' => '09h00 – 12h30',
            ],
            'email'      => 'stgervais@lessaveursdujardin.fr',
            'directeurs' => $directeurs,
            'managers'   => $managers,
            'google_reviews_url'      => 'https://www.google.com/maps/search/Les+Saveurs+du+Jardin+Saint-Gervais-la-For%C3%AAt+113B+Rte+Nationale',
            'google_write_review_url' => 'https://search.google.com/local/writereview?placeid=' . self::PLACE_IDS['St Gervais'],
        ] + $this->getGoogleData($gps, 'St Gervais'));
    }

    #[Route('/contact/villemandeur', name: 'app_contact_villemandeur')]
    public function villemandeur(UserRepository $userRepo, GooglePlacesService $gps): Response
    {
        $directeurs = $userRepo->findByRole('ROLE_DIRECTEUR');
        $managers = $userRepo->createQueryBuilder('u')
            ->join('u.roleEntity', 'r')
            ->where('u.magasin = :mag')
            ->andWhere('r.isContact = true')
            ->setParameter('mag', 'Villemandeur')
            ->getQuery()
            ->getResult();

        return $this->render('static/villemandeur.html.twig', [
            'magasin_name' => 'Les Saveurs du Jardin - Villemandeur',
            'address' => '69 Rue Jean Mermoz, 45700 Villemandeur',
            'phone' => '02 19 00 48 49',
            'instagram' => 'https://www.instagram.com/les_saveurs_du_jardin/',
            'hours' => [
                'Lundi' => 'Fermé',
                'Mardi' => '09h00 – 19h00',
                'Mercredi' => '09h00 – 19h00',
                'Jeudi' => '09h00 – 19h00',
                'Vendredi' => '09h00 – 19h00',
                'Samedi' => '09h00 – 19h00',
                'Dimanche' => '09h00 – 13h00',
            ],
            'email'      => 'villemandeur@lessaveursdujardin.fr',
            'directeurs' => $directeurs,
            'managers'   => $managers,
            'google_reviews_url'      => 'https://www.google.com/maps/search/Les+Saveurs+du+Jardin+Villemandeur+69+Rue+Jean+Mermoz',
            'google_write_review_url' => 'https://search.google.com/local/writereview?placeid=' . self::PLACE_IDS['Villemandeur'],
        ] + $this->getGoogleData($gps, 'Villemandeur'));
    }

    #[Route('/contact/saran', name: 'app_contact_saran')]
    public function saran(UserRepository $userRepo, GooglePlacesService $gps): Response
    {
        $directeurs = $userRepo->findByRole('ROLE_DIRECTEUR');
        $managers = $userRepo->createQueryBuilder('u')
            ->join('u.roleEntity', 'r')
            ->where('u.magasin = :mag')
            ->andWhere('r.isContact = true')
            ->setParameter('mag', 'Saran')
            ->getQuery()
            ->getResult();

        return $this->render('static/saran.html.twig', [
            'magasin_name' => 'Les Saveurs du Jardin - Saran',
            'address' => '1111 Route Nationale 20, 45770 Saran',
            'phone' => 'Non disponible',
            'instagram' => 'https://www.instagram.com/les_saveurs_du_jardin/',
            'hours' => [
                'Lundi' => '09h00 – 19h30',
                'Mardi' => '09h00 – 19h30',
                'Mercredi' => '09h00 – 19h30',
                'Jeudi' => '09h00 – 19h30',
                'Vendredi' => '09h00 – 19h30',
                'Samedi' => '09h00 – 19h30',
                'Dimanche' => '09h00 – 12h30',
            ],
            'email'      => 'saran@lessaveursdujardin.fr',
            'directeurs' => $directeurs,
            'managers'   => $managers,
            'google_reviews_url'      => 'https://www.google.com/maps/search/Les+Saveurs+du+Jardin+Saran+1111+Route+Nationale+20',
            'google_write_review_url' => 'https://search.google.com/local/writereview?placeid=' . self::PLACE_IDS['Saran'],
        ] + $this->getGoogleData($gps, 'Saran'));
    }

    #[Route('/contact/noyers', name: 'app_contact_noyers')]
    public function noyers(UserRepository $userRepo, GooglePlacesService $gps): Response
    {
        $directeurs = $userRepo->findByRole('ROLE_DIRECTEUR');
        $managers = $userRepo->createQueryBuilder('u')
            ->join('u.roleEntity', 'r')
            ->where('u.magasin = :mag')
            ->andWhere('r.isContact = true')
            ->setParameter('mag', 'Noyers')
            ->getQuery()
            ->getResult();

        return $this->render('static/noyers.html.twig', [
            'magasin_name' => 'Les Saveurs du Jardin - Noyers',
            'address' => '14 Rue André Boulle, 41140 Noyers-sur-Cher',
            'phone' => '09 81 10 23 29',
            'instagram' => 'https://www.instagram.com/les_saveurs_du_jardin/',
            'hours' => [
                'Lundi' => '09h00 – 19h30',
                'Mardi' => '09h00 – 19h30',
                'Mercredi' => '09h00 – 19h30',
                'Jeudi' => '09h00 – 19h30',
                'Vendredi' => '09h00 – 19h30',
                'Samedi' => '09h00 – 19h30',
                'Dimanche' => '09h00 – 12h30',
            ],
            'email'      => 'noyers@lessaveursdujardin.fr',
            'directeurs' => $directeurs,
            'managers'   => $managers,
            'google_reviews_url'      => 'https://www.google.com/maps/search/Les+Saveurs+du+Jardin+Noyers-sur-Cher+14+Rue+Andr%C3%A9+Boulle',
            'google_write_review_url' => 'https://search.google.com/local/writereview?placeid=' . self::PLACE_IDS['Noyers'],
        ] + $this->getGoogleData($gps, 'Noyers'));
    }
}


