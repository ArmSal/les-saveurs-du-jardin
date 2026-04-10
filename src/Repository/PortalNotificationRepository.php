<?php

namespace App\Repository;

use App\Entity\PortalNotification;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortalNotification>
 *
 * @method PortalNotification|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortalNotification|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortalNotification[]    findAll()
 * @method PortalNotification[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortalNotificationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortalNotification::class);
    }

    /**
     * @return PortalNotification[]
     */
    public function findLatestForUser($user, int $limit = 5): array
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.user = :user')
            ->setParameter('user', $user)
            ->orderBy('n.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function countUnreadForUser($user): int
    {
        return $this->createQueryBuilder('n')
            ->select('count(n.id)')
            ->andWhere('n.user = :user')
            ->andWhere('n.isRead = :isRead')
            ->setParameter('user', $user)
            ->setParameter('isRead', false)
            ->getQuery()
            ->getSingleScalarResult();
    }
}


