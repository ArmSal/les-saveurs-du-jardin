<?php

namespace App\Repository;

use App\Entity\UserObservation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<UserObservation>
 */
class UserObservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserObservation::class);
    }

    /**
     * Find observation by user and month
     */
    public function findByUserAndMonth(int $userId, ?string $mois = null): ?UserObservation
    {
        $qb = $this->createQueryBuilder('uo')
            ->where('uo.user = :userId')
            ->andWhere('uo.isActive = true')
            ->setParameter('userId', $userId);

        if ($mois) {
            $qb->andWhere('uo.mois = :mois')
               ->setParameter('mois', $mois);
        } else {
            $qb->andWhere('uo.mois IS NULL');
        }

        return $qb->orderBy('uo.createdAt', 'DESC')
                  ->setMaxResults(1)
                  ->getQuery()
                  ->getOneOrNullResult();
    }

    /**
     * Find all observations with filters
     */
    public function findAllWithFilters(?string $magasin = null, ?string $mois = null): array
    {
        $qb = $this->createQueryBuilder('uo')
            ->leftJoin('uo.user', 'u')
            ->where('uo.isActive = true')
            ->andWhere("u.magasin != 'Client'")
            ->andWhere('u.magasin IS NOT NULL');

        if ($magasin) {
            $qb->andWhere('u.magasin = :magasin')
               ->setParameter('magasin', $magasin);
        }

        if ($mois) {
            $qb->andWhere('uo.mois = :mois')
               ->setParameter('mois', $mois);
        }

        return $qb->orderBy('u.magasin', 'ASC')
                  ->addOrderBy('u.nom', 'ASC')
                  ->getQuery()
                  ->getResult();
    }

    /**
     * Get all active users with their latest observation
     */
    public function getAllUsersWithObservations(?string $magasin = null, ?string $mois = null): array
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = '
            SELECT u.id, u.prenom, u.nom, u.magasin,
                   uo.observation, uo.ticket_restaurant, uo.mois
            FROM user u
            LEFT JOIN user_observations uo ON u.id = uo.user_id 
                AND uo.is_active = 1
                AND (:mois IS NULL OR uo.mois = :mois)
            WHERE u.magasin != "Client" 
            AND u.magasin IS NOT NULL
        ';

        $params = ['mois' => $mois];
        $types = ['mois' => $mois ? \PDO::PARAM_STR : \PDO::PARAM_NULL];

        if ($magasin) {
            $sql .= ' AND u.magasin = :magasin';
            $params['magasin'] = $magasin;
            $types['magasin'] = \PDO::PARAM_STR;
        }

        $sql .= ' ORDER BY u.magasin ASC, u.nom ASC';

        return $conn->executeQuery($sql, $params, $types)->fetchAllAssociative();
    }
}
