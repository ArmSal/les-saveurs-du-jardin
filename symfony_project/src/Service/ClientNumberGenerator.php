<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class ClientNumberGenerator
{
    public function __construct(
        private readonly EntityManagerInterface $em
    ) {
    }

    public function generate(): string
    {
        $lastUser = $this->em->getRepository(User::class)->findOneBy([], ['id' => 'DESC']);
        $nextId = $lastUser ? $lastUser->getId() + 1 : 1;

        return '900091' . str_pad((string) $nextId, 4, '0', STR_PAD_LEFT);
    }
}


