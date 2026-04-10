<?php

namespace App\Repository;

use App\Entity\PortalConge;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortalConge>
 *
 * @method PortalConge|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortalConge|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortalConge[]    findAll()
 * @method PortalConge[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortalCongeRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortalConge::class);
    }
}


