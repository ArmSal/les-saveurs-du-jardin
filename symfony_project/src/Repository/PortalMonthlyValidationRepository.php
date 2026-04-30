<?php

namespace App\Repository;

use App\Entity\PortalMonthlyValidation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortalMonthlyValidation>
 *
 * @method PortalMonthlyValidation|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortalMonthlyValidation|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortalMonthlyValidation[]    findAll()
 * @method PortalMonthlyValidation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortalMonthlyValidationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortalMonthlyValidation::class);
    }
}


