<?php

namespace App\Entity;

use App\Repository\TransEtLogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransEtLogRepository::class)]
#[ORM\Table(name: 'trans_et_log')]
#[ORM\HasLifecycleCallbacks]
class TransEtLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date = null;

    #[ORM\ManyToOne(targetEntity: TransEtLogCamion::class, inversedBy: 'tours')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TransEtLogCamion $camion = null;

    /**
     * @var Collection<int, Magasin>
     */
    #[ORM\ManyToMany(targetEntity: Magasin::class)]
    #[ORM\JoinTable(name: 'trans_et_log_magasin')]
    private Collection $magasins;

    #[ORM\Column(length: 200, nullable: true)]
    private ?string $observation = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $updatedAt = null;

    public function __construct()
    {
        $this->magasins = new ArrayCollection();
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): static
    {
        $this->date = $date;
        return $this;
    }

    public function getCamion(): ?TransEtLogCamion
    {
        return $this->camion;
    }

    public function setCamion(?TransEtLogCamion $camion): static
    {
        $this->camion = $camion;
        return $this;
    }

    /**
     * @return Collection<int, Magasin>
     */
    public function getMagasins(): Collection
    {
        return $this->magasins;
    }

    public function addMagasin(Magasin $magasin): static
    {
        if (!$this->magasins->contains($magasin)) {
            $this->magasins->add($magasin);
        }
        return $this;
    }

    public function removeMagasin(Magasin $magasin): static
    {
        $this->magasins->removeElement($magasin);
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }
}
