<?php

namespace App\Repository;

use App\Entity\ObservationMonthLock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ObservationMonthLock>
 */
class ObservationMonthLockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ObservationMonthLock::class);
    }

    public function findByMois(string $mois): ?ObservationMonthLock
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.mois = :mois')
            ->setParameter('mois', $mois)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function isMonthLocked(string $mois): bool
    {
        $lock = $this->findByMois($mois);
        return $lock ? $lock->isLocked() : false;
    }
}
