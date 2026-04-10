<?php

namespace App\Repository;

use App\Entity\CleaningTask;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class CleaningTaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, CleaningTask::class);
    }

    public function findByFilters(?\DateTimeInterface $dateFrom, ?\DateTimeInterface $dateTo, ?int $magasinId, ?int $userId, bool $isFullAccess, User $currentUser): array
    {
        $qb = $this->createQueryBuilder('ct')
            ->leftJoin('ct.magasin', 'm')
            ->leftJoin('ct.user', 'u')
            ->addSelect('m', 'u')
            ->orderBy('ct.date', 'DESC');

        if (!$isFullAccess) {
            $qb->andWhere('ct.user = :currentUser')
               ->setParameter('currentUser', $currentUser);
        }

        if ($dateFrom) {
            $qb->andWhere('ct.date >= :dateFrom')
               ->setParameter('dateFrom', $dateFrom);
        }

        if ($dateTo) {
            $qb->andWhere('ct.date <= :dateTo')
               ->setParameter('dateTo', $dateTo);
        }

        if ($magasinId) {
            $qb->andWhere('m.id = :magasinId')
               ->setParameter('magasinId', $magasinId);
        }

        if ($userId && $isFullAccess) {
            $qb->andWhere('u.id = :userId')
               ->setParameter('userId', $userId);
        }

        return $qb->getQuery()->getResult();
    }

    public function findRecent(int $limit = 50, ?User $currentUser = null, bool $isFullAccess = false): array
    {
        $qb = $this->createQueryBuilder('ct')
            ->leftJoin('ct.magasin', 'm')
            ->leftJoin('ct.user', 'u')
            ->addSelect('m', 'u')
            ->orderBy('ct.date', 'DESC')
            ->setMaxResults($limit);

        if (!$isFullAccess && $currentUser) {
            $qb->andWhere('ct.user = :currentUser')
               ->setParameter('currentUser', $currentUser);
        }

        return $qb->getQuery()->getResult();
    }
}
