<?php

namespace App\Entity;

use App\Repository\PortalProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PortalProductRepository::class)]
class PortalProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $reference = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $code_barre = '000000';

    #[ORM\Column(length: 255)]
    private ?string $designation = null;

    #[ORM\Column(length: 50)]
    private ?string $unite = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 5, scale: 2)]
    private ?string $tva = '20.00';

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2, nullable: true)]
    private ?string $prix = '0.00';

    #[ORM\Column(length: 1000, nullable: true)]
    private ?string $image_url = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: Types::INTEGER, nullable: true)]
    private ?int $qte_stock = 0;

    #[ORM\ManyToOne(targetEntity: PortalCategorieProduit::class, inversedBy: 'products')]
    private ?PortalCategorieProduit $categoryEntity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;
        return $this;
    }

    public function getCodeBarre(): ?string
    {
        return $this->code_barre ?? '000000';
    }

    public function setCodeBarre(?string $code_barre): static
    {
        $this->code_barre = $code_barre;
        return $this;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): static
    {
        $this->designation = $designation;
        return $this;
    }

    public function getUnite(): ?string
    {
        return $this->unite;
    }

    public function setUnite(string $unite): static
    {
        $this->unite = $unite;
        return $this;
    }

    public function getTva(): ?string
    {
        return $this->tva;
    }

    public function setTva(string $tva): static
    {
        $this->tva = $tva;
        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(?string $prix): static
    {
        $this->prix = $prix;
        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(?string $image_url): static
    {
        $this->image_url = $image_url;
        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function getQteStock(): ?int
    {
        return $this->qte_stock;
    }

    public function getqte_stock(): ?int
    {
        return $this->qte_stock;
    }

    public function setQteStock(?int $qte_stock): static
    {
        $this->qte_stock = $qte_stock;
        return $this;
    }

    public function getCategoryEntity(): ?PortalCategorieProduit
    {
        return $this->categoryEntity;
    }

    public function setCategoryEntity(?PortalCategorieProduit $categoryEntity): static
    {
        $this->categoryEntity = $categoryEntity;
        return $this;
    }
}
