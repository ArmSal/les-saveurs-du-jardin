<?php

namespace App\Controller;

use Firebase\JWT\JWT;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

class SecurityController extends AbstractController
{
    private string $jwtSecret = 'votre_cle_secrete_super_securise_12345';

    #[Route('/api/login', name: 'api_login', methods: ['POST'])]
    public function login(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $email = $data['email'] ?? null;
        $password = $data['password'] ?? null;

        // Simulation simple d'un utilisateur (à remplacer par la DB en Rendu 2)
        if ($email === 'admin@lsdj.fr' && $password === 'password123') {
            $payload = [
                'iat' => time(),
                'exp' => time() + 3600, // Expire dans 1 heure
                'user' => $email,
            ];

            $token = JWT::encode($payload, $this->jwtSecret, 'HS256');

            return new JsonResponse(['token' => $token]);
        }

        return new JsonResponse(['error' => 'Identifiants invalides'], 401);
    }
}
