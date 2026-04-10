<?php

namespace App\Repository;

use App\Entity\TransEtLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TransEtLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TransEtLog::class);
    }

    public function findByFilters(?\DateTimeInterface $dateFrom, ?\DateTimeInterface $dateTo, ?int $camionId, ?int $magasinId, string $sort = 'date', string $order = 'DESC'): array
    {
        $qb = $this->createQueryBuilder('t')
            ->leftJoin('t.camion', 'c')
            ->leftJoin('t.magasins', 'm')
            ->addSelect('c', 'm');

        if ($dateFrom) {
            $qb->andWhere('t.date >= :dateFrom')
               ->setParameter('dateFrom', $dateFrom);
        }

        if ($dateTo) {
            $qb->andWhere('t.date <= :dateTo')
               ->setParameter('dateTo', $dateTo);
        }

        if ($camionId) {
            $qb->andWhere('c.id = :camionId')
               ->setParameter('camionId', $camionId);
        }

        if ($magasinId) {
            $qb->andWhere('m.id = :magasinId')
               ->setParameter('magasinId', $magasinId);
        }

        $allowedSorts = ['date', 'createdAt', 'updatedAt'];
        $sortField = in_array($sort, $allowedSorts) ? 't.' . $sort : 't.date';
        $order = strtoupper($order) === 'ASC' ? 'ASC' : 'DESC';

        $qb->orderBy($sortField, $order);

        return $qb->getQuery()->getResult();
    }

    public function findRecent(int $limit = 50): array
    {
        return $this->createQueryBuilder('t')
            ->leftJoin('t.camion', 'c')
            ->leftJoin('t.magasins', 'm')
            ->addSelect('c', 'm')
            ->orderBy('t.date', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
