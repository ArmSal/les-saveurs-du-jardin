<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
#[ORM\Table(name: 'portal_commandes')]
class Commande
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_UPDATED = 'updated';
    public const STATUS_CONFIRMED = 'confirmed';
    public const STATUS_PROCESSING = 'processing';
    public const STATUS_PROCESSED = 'processed';
    public const STATUS_DELIVERED = 'delivered';
    public const STATUS_ARCHIVED = 'archived';
    public const STATUS_CANCELED = 'canceled';

    public const STATUS_LABELS_FR = [
        self::STATUS_PENDING => 'En attente',
        self::STATUS_UPDATED => 'Modifiée',
        self::STATUS_CONFIRMED => 'Confirmée',
        self::STATUS_PROCESSING => 'En préparation',
        self::STATUS_PROCESSED => 'Préparée',
        self::STATUS_DELIVERED => 'Livrée',
        self::STATUS_ARCHIVED => 'Archivée',
        self::STATUS_CANCELED => 'Annulée',
    ];

    public function getStatusLabelFr(): string
    {
        return self::STATUS_LABELS_FR[$this->status] ?? $this->status;
    }

    public const STATUSES = [
        self::STATUS_PENDING,
        self::STATUS_UPDATED,
        self::STATUS_CONFIRMED,
        self::STATUS_PROCESSING,
        self::STATUS_PROCESSED,
        self::STATUS_DELIVERED,
        self::STATUS_ARCHIVED,
        self::STATUS_CANCELED,
    ];

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 160, unique: true)]
    private string $slug;

    #[ORM\Column]
    private \DateTimeImmutable $createdAt;

    #[ORM\Column(length: 20)]
    private string $status = self::STATUS_PENDING;

    #[ORM\ManyToOne(inversedBy: 'commandes')]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    /**
     * @var Collection<int, CommandeItem>
     */
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeItem::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $items;

    /**
     * @var Collection<int, CommandeHistory>
     */
    #[ORM\OneToMany(mappedBy: 'commande', targetEntity: CommandeHistory::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $histories;

    public function __construct()
    {
        $this->slug = bin2hex(random_bytes(8));
        $this->createdAt = new \DateTimeImmutable();
        $this->items = new ArrayCollection();
        $this->histories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        if (!in_array($status, self::STATUSES, true)) {
            throw new \InvalidArgumentException('Invalid status');
        }
        $this->status = $status;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return Collection<int, CommandeItem>
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    public function addItem(CommandeItem $item): self
    {
        if (!$this->items->contains($item)) {
            $this->items->add($item);
            $item->setCommande($this);
        }

        return $this;
    }

    public function removeItem(CommandeItem $item): self
    {
        if ($this->items->removeElement($item)) {
            if ($item->getCommande() === $this) {
                $item->setCommande(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CommandeHistory>
     */
    public function getHistories(): Collection
    {
        return $this->histories;
    }

    public function addHistory(CommandeHistory $history): static
    {
        if (!$this->histories->contains($history)) {
            $this->histories->add($history);
            $history->setCommande($this);
        }

        return $this;
    }

    public function removeHistory(CommandeHistory $history): static
    {
        if ($this->histories->removeElement($history)) {
            // set the owning side to null (unless already changed)
            if ($history->getCommande() === $this) {
                $history->setCommande(null);
            }
        }

        return $this;
    }
}


