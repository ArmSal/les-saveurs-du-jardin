<?php

namespace App\Entity;

use App\Repository\UserObservationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserObservationRepository::class)]
#[ORM\Table(name: 'user_observations')]
#[ORM\Index(columns: ['user_id'], name: 'idx_user_observation_user')]
#[ORM\Index(columns: ['mois'], name: 'idx_user_observation_mois')]
class UserObservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'observations')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?User $user = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $observation = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true, options: ['unsigned' => true])]
    private ?int $ticketRestaurant = null;

    #[ORM\Column(length: 7, nullable: true)]
    private ?string $mois = null; // Format: YYYY-MM (e.g., 2026-04)

    #[ORM\Column(options: ['default' => false])]
    private bool $isActive = true;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;
        return $this;
    }

    public function getObservation(): ?string
    {
        return $this->observation;
    }

    public function setObservation(?string $observation): static
    {
        $this->observation = $observation;
        return $this;
    }

    public function getTicketRestaurant(): ?int
    {
        return $this->ticketRestaurant;
    }

    public function setTicketRestaurant(?int $ticketRestaurant): static
    {
        if ($ticketRestaurant !== null && ($ticketRestaurant < 0 || $ticketRestaurant > 99)) {
            throw new \InvalidArgumentException('Ticket Restaurant must be between 0 and 99');
        }
        $this->ticketRestaurant = $ticketRestaurant;
        return $this;
    }

    public function getMois(): ?string
    {
        return $this->mois;
    }

    public function setMois(?string $mois): static
    {
        $this->mois = $mois;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setActive(bool $isActive): static
    {
        $this->isActive = $isActive;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    #[ORM\PreUpdate]
    public function updateTimestamp(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }
}
