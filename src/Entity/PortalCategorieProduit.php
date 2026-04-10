<?php

namespace App\Entity;

use App\Repository\PortalCategorieProduitRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortalCategorieProduitRepository::class)]
class PortalCategorieProduit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\OneToMany(mappedBy: 'categoryEntity', targetEntity: PortalProduct::class)]
    private Collection $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
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

    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(PortalProduct $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setCategoryEntity($this);
        }
        return $this;
    }

    public function removeProduct(PortalProduct $product): static
    {
        if ($this->products->removeElement($product)) {
            if ($product->getCategoryEntity() === $this) {
                $product->setCategoryEntity(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return (string) $this->nom;
    }
}
