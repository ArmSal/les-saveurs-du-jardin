<?php

namespace App\Entity;

use App\Repository\ObservationMonthLockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ObservationMonthLockRepository::class)]
#[ORM\Table(name: 'observation_month_locks', uniqueConstraints: [
    new ORM\UniqueConstraint(name: 'uniq_month_lock', columns: ['mois'])
])]
class ObservationMonthLock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 7)]
    private ?string $mois = null; // Format: YYYY-MM

    #[ORM\Column]
    private ?bool $isLocked = false;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $lockedBy = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $lockedAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(string $mois): self
    {
        $this->mois = $mois;
        return $this;
    }

    public function isLocked(): ?bool
    {
        return $this->isLocked;
    }

    public function setIsLocked(bool $isLocked): self
    {
        $this->isLocked = $isLocked;
        return $this;
    }

    public function getLockedBy(): ?User
    {
        return $this->lockedBy;
    }

    public function setLockedBy(?User $lockedBy): self
    {
        $this->lockedBy = $lockedBy;
        return $this;
    }

    public function getLockedAt(): ?\DateTimeInterface
    {
        return $this->lockedAt;
    }

    public function setLockedAt(?\DateTimeInterface $lockedAt): self
    {
        $this->lockedAt = $lockedAt;
        return $this;
    }
}
