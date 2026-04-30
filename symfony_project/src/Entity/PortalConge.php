<?php

namespace App\Entity;

use App\Repository\PortalCongeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortalCongeRepository::class)]
#[ORM\Table(name: 'portal_conges')]
class PortalConge
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(length: 20)]
    private ?string $type = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $employeeComment = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $adminComment = null;

    #[ORM\Column(length: 20)]
    private ?string $status = 'PENDING';

    #[ORM\Column(type: Types::JSON, nullable: true)]
    private ?array $history = [];

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $approvedSignature = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $approvedAt = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $approvedBy = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1, nullable: true)]
    private ?string $paidDays = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1, nullable: true)]
    private ?string $unpaidDays = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 4, scale: 1, nullable: true)]
    private ?string $totalDays = null;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;
        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;
        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;
        return $this;
    }

    public function getEmployeeComment(): ?string
    {
        return $this->employeeComment;
    }

    public function setEmployeeComment(?string $employeeComment): static
    {
        $this->employeeComment = $employeeComment;
        return $this;
    }

    public function getAdminComment(): ?string
    {
        return $this->adminComment;
    }

    public function setAdminComment(?string $adminComment): static
    {
        $this->adminComment = $adminComment;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;
        return $this;
    }

    public function getHistory(): ?array
    {
        return $this->history;
    }

    public function setHistory(?array $history): static
    {
        $this->history = $history;
        return $this;
    }

    public function addHistoryEntry(string $who, string $action, ?string $comment = null, ?\DateTimeInterface $startDate = null, ?\DateTimeInterface $endDate = null, ?float $paidDays = null, ?float $unpaidDays = null, ?float $totalDays = null): self
    {
        $this->history[] = [
            'at' => (new \DateTime())->format('Y-m-d H:i:s'),
            'who' => $who,
            'action' => $action,
            'comment' => $comment,
            'startDate' => $startDate ? $startDate->format('Y-m-d') : null,
            'endDate' => $endDate ? $endDate->format('Y-m-d') : null,
            'paidDays' => $paidDays,
            'unpaidDays' => $unpaidDays,
            'totalDays' => $totalDays,
        ];
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function getApprovedSignature(): ?string
    {
        return $this->approvedSignature;
    }

    public function setApprovedSignature(?string $approvedSignature): static
    {
        $this->approvedSignature = $approvedSignature;
        return $this;
    }

    public function getApprovedAt(): ?\DateTimeInterface
    {
        return $this->approvedAt;
    }

    public function setApprovedAt(?\DateTimeInterface $approvedAt): static
    {
        $this->approvedAt = $approvedAt;
        return $this;
    }

    public function getApprovedBy(): ?string
    {
        return $this->approvedBy;
    }

    public function setApprovedBy(?string $approvedBy): static
    {
        $this->approvedBy = $approvedBy;
        return $this;
    }

    public function getPaidDays(): ?float
    {
        return $this->paidDays !== null ? (float) $this->paidDays : null;
    }

    public function setPaidDays(?float $paidDays): static
    {
        $this->paidDays = $paidDays !== null ? (string) $paidDays : null;
        return $this;
    }

    public function getUnpaidDays(): ?float
    {
        return $this->unpaidDays !== null ? (float) $this->unpaidDays : null;
    }

    public function setUnpaidDays(?float $unpaidDays): static
    {
        $this->unpaidDays = $unpaidDays !== null ? (string) $unpaidDays : null;
        return $this;
    }

    public function getTotalDays(): ?float
    {
        return $this->totalDays !== null ? (float) $this->totalDays : null;
    }

    public function setTotalDays(?float $totalDays): static
    {
        $this->totalDays = $totalDays !== null ? (string) $totalDays : null;
        return $this;
    }
}


