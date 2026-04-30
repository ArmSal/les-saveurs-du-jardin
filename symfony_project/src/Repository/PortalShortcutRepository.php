<?php

namespace App\Repository;

use App\Entity\PortalShortcut;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortalShortcut>
 */
class PortalShortcutRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortalShortcut::class);
    }

    /**
     * @return PortalShortcut[] Returns an array of PortalShortcut objects ordered by displayOrder
     */
    public function findAllOrdered(): array
    {
        return $this->createQueryBuilder('s')
            ->orderBy('s.displayOrder', 'ASC')
            ->getQuery()
            ->getResult();
    }
}


