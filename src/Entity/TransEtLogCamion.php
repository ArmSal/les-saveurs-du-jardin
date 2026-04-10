<?php

namespace App\Entity;

use App\Repository\TransEtLogCamionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TransEtLogCamionRepository::class)]
#[ORM\Table(name: 'trans_et_log_camion')]
class TransEtLogCamion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $nom = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $immatriculation = null;

    #[ORM\Column(options: ["default" => true])]
    private bool $isActive = true;

    /**
     * @var Collection<int, TransEtLog>
     */
    #[ORM\OneToMany(mappedBy: 'camion', targetEntity: TransEtLog::class)]
    private Collection $tours;

    public function __construct()
    {
        $this->tours = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;
        return $this;
    }

    public function getImmatriculation(): ?string
    {
        return $this->immatriculation;
    }

    public function setImmatriculation(?string $immatriculation): static
    {
        $this->immatriculation = $immatriculation;
        return $this;
    }

    public function isActive(): bool
    {
        return $this->isActive;
    }

    public function setIsActive(bool $isActive): static
    {
        $this->isActive = $isActive;
        return $this;
    }

    /**
     * @return Collection<int, TransEtLog>
     */
    public function getTours(): Collection
    {
        return $this->tours;
    }

    public function addTour(TransEtLog $tour): static
    {
        if (!$this->tours->contains($tour)) {
            $this->tours->add($tour);
            $tour->setCamion($this);
        }
        return $this;
    }

    public function removeTour(TransEtLog $tour): static
    {
        if ($this->tours->removeElement($tour)) {
            if ($tour->getCamion() === $this) {
                $tour->setCamion(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        if ($this->immatriculation) {
            return sprintf('%s (%s)', $this->nom, $this->immatriculation);
        }
        return $this->nom;
    }
}
