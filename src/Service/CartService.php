<?php

namespace App\Service;

use App\Entity\PortalProduct;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private const SESSION_KEY = 'cart_items';

    public function __construct(
        private RequestStack $requestStack,
        private EntityManagerInterface $em
    ) {}

    public function getItemCount(): int
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get(self::SESSION_KEY, []);
        
        if (!is_array($cart)) {
            return 0;
        }

        $total = 0;
        foreach ($cart as $qty) {
            $total += (int) $qty;
        }

        return $total;
    }

    public function getUniqueItemCount(): int
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get(self::SESSION_KEY, []);
        
        return is_array($cart) ? count($cart) : 0;
    }

    public function getTotals(): array
    {
        $session = $this->requestStack->getSession();
        $cart = $session->get(self::SESSION_KEY, []);
        
        $subtotal = 0;
        $totalItems = 0;

        if (is_array($cart)) {
            foreach ($cart as $id => $qty) {
                $product = $this->em->getRepository(PortalProduct::class)->find((int)$id);
                if ($product) {
                    $subtotal += (float)$product->getPrix() * (int)$qty;
                    $totalItems += (int)$qty;
                }
            }
        }

        $tva = $subtotal * 0.20;
        $totalTTC = $subtotal + $tva;

        return [
            'subtotal' => $subtotal,
            'totalItems' => $totalItems,
            'tva' => $tva,
            'totalTTC' => $totalTTC,
            'uniqueCount' => is_array($cart) ? count($cart) : 0
        ];
    }
}
