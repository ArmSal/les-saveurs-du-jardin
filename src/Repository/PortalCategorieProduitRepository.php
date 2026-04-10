<?php

namespace App\Repository;

use App\Entity\PortalCategorieProduit;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortalCategorieProduit>
 */
class PortalCategorieProduitRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortalCategorieProduit::class);
    }

    /**
     * @return PortalCategorieProduit[]
     */
    public function findAllOrderByName(): array
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.nom', 'ASC')
            ->getQuery()
            ->getResult();
    }
}
