<?php

namespace App\Repository;

use App\Entity\PortalWeekLock;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PortalWeekLockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortalWeekLock::class);
    }

    public function findByWeekAndMagasin(int $week, int $year, string $magasin): ?PortalWeekLock
    {
        return $this->createQueryBuilder('w')
            ->where('w.weekNumber = :week')
            ->andWhere('w.year = :year')
            ->andWhere('w.magasin = :magasin')
            ->setParameter('week', $week)
            ->setParameter('year', $year)
            ->setParameter('magasin', $magasin)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findByWeek(int $week, int $year): array
    {
        return $this->createQueryBuilder('w')
            ->where('w.weekNumber = :week')
            ->andWhere('w.year = :year')
            ->andWhere('w.isLocked = :locked')
            ->setParameter('week', $week)
            ->setParameter('year', $year)
            ->setParameter('locked', true)
            ->getQuery()
            ->getResult();
    }

    public function findLockedMagasinsForWeek(int $week, int $year): array
    {
        $result = $this->createQueryBuilder('w')
            ->select('w.magasin')
            ->where('w.weekNumber = :week')
            ->andWhere('w.year = :year')
            ->andWhere('w.isLocked = :locked')
            ->setParameter('week', $week)
            ->setParameter('year', $year)
            ->setParameter('locked', true)
            ->getQuery()
            ->getScalarResult();

        return array_column($result, 'magasin');
    }
}
