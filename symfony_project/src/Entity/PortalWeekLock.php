<?php

namespace App\Entity;

use App\Repository\PortalWeekLockRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortalWeekLockRepository::class)]
#[ORM\Table(name: 'portal_week_locks', uniqueConstraints: [
    new ORM\UniqueConstraint(name: 'uniq_week_lock', columns: ['magasin', 'week_number', 'year'])
])]
class PortalWeekLock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $magasin = null;

    #[ORM\Column]
    private ?int $weekNumber = null;

    #[ORM\Column]
    private ?int $year = null;

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

    public function getMagasin(): ?string
    {
        return $this->magasin;
    }

    public function setMagasin(string $magasin): self
    {
        $this->magasin = $magasin;
        return $this;
    }

    public function getWeekNumber(): ?int
    {
        return $this->weekNumber;
    }

    public function setWeekNumber(int $weekNumber): self
    {
        $this->weekNumber = $weekNumber;
        return $this;
    }

    public function getYear(): ?int
    {
        return $this->year;
    }

    public function setYear(int $year): self
    {
        $this->year = $year;
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
