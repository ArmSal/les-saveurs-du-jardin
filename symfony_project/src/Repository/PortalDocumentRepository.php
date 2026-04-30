<?php

namespace App\Repository;

use App\Entity\PortalDocument;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortalDocument>
 *
 * @method PortalDocument|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortalDocument|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortalDocument[]    findAll()
 * @method PortalDocument[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortalDocumentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortalDocument::class);
    }

    public function save(PortalDocument $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PortalDocument $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}


