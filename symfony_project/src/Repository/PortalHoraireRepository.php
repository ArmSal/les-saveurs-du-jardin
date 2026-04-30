<?php

namespace App\Repository;

use App\Entity\PortalHoraire;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PortalHoraire>
 *
 * @method PortalHoraire|null find($id, $lockMode = null, $lockVersion = null)
 * @method PortalHoraire|null findOneBy(array $criteria, array $orderBy = null)
 * @method PortalHoraire[]    findAll()
 * @method PortalHoraire[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PortalHoraireRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PortalHoraire::class);
    }

    /**
     * Checks if a user has an overlapping event in the agenda.
     * All-day events (stored as X 00:00 to Y 00:00 inclusive) are adjusted to exclusive ranges (X to Y+1) for check.
     */
    public function checkOverlap(\App\Entity\User $user, \DateTimeInterface $start, \DateTimeInterface $end, ?int $excludeId = null): bool
    {
        $qStart = \DateTime::createFromInterface($start);
        $qEnd = \DateTime::createFromInterface($end);

        // If it's an all-day event (inclusive in our DB), internal comparison needs it exclusive
        if ($qStart->format('H:i:s') === '00:00:00' && $qEnd->format('H:i:s') === '00:00:00') {
             $qEnd->modify('+1 day');
        }

        $horaires = $this->findBy(['user' => $user]);

        foreach ($horaires as $h) {
            if ($excludeId && $h->getId() === $excludeId) {
                continue;
            }

            $hStart = \DateTime::createFromInterface($h->getStartTime());
            $hEnd = \DateTime::createFromInterface($h->getEndTime());

            // All-day inclusive to exclusive for comparison
            if ($hStart->format('H:i:s') === '00:00:00' && $hEnd->format('H:i:s') === '00:00:00') {
                $hEnd->modify('+1 day');
            }

            // Standard overlap: (StartA < EndB) and (EndA > StartB)
            if ($hStart < $qEnd && $hEnd > $qStart) {
                return true;
            }
        }

        return false;
    }
}


