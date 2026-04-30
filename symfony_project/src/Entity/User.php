<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 3)]
    private string $civility = 'Mr';

    #[ORM\Column(length: 100)]
    private string $nom = '';

    #[ORM\Column(length: 100)]
    private string $prenom = '';

    #[ORM\Column(type: 'date', nullable: true)]
    private ?\DateTimeInterface $date_naissance = null;

    #[ORM\Column(length: 10, nullable: true)]
    private ?string $code_postal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse_complement = null;

    #[ORM\Column(length: 20, nullable: true)]
    private ?string $telephone = null;

    #[ORM\Column(length: 20, unique: true, nullable: true)]
    private ?string $client_number = null;

    /**
     * @var Collection<int, Commande>
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Commande::class, orphanRemoval: true)]
    private Collection $commandes;

    #[ORM\Column(name: "is_active", options: ["default" => true])]
    private bool $is_active = true;

    #[ORM\Column(length: 100, nullable: true, options: ["default" => "Client"])]
    private ?string $magasin = 'Client';

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Magasin $magasinEntity = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Role $roleEntity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photo = null;

    #[ORM\Column(length: 10, nullable: true, options: ["default" => "#4f46e5"])]
    private ?string $calendar_color = "#4f46e5";

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $signature = null;

    #[ORM\Column(type: 'boolean', options: ["default" => false])]
    private bool $validation_horaire = false;

    #[ORM\Column(type: 'boolean', options: ["default" => false])]
    private bool $demande_conge = false;

    #[ORM\Column(type: 'boolean', options: ["default" => false])]
    private bool $documents_rh = false;

    /**
     * @var Collection<int, UserObservation>
     */
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: UserObservation::class, orphanRemoval: true)]
    private Collection $observations;

    public function __construct()
    {
        $this->commandes = new ArrayCollection();
        $this->observations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        
        if ($this->roleEntity) {
            $roles[] = $this->roleEntity->getName();
        }

        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getCivility(): string
    {
        return $this->civility;
    }

    public function setCivility(string $civility): self
    {
        $this->civility = $civility;
        return $this;
    }

    public function getNom(): string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;
        return $this;
    }

    public function getPrenom(): string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;
        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->date_naissance;
    }

    public function setDateNaissance(?\DateTimeInterface $date_naissance): self
    {
        $this->date_naissance = $date_naissance;
        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(?string $code_postal): self
    {
        $this->code_postal = $code_postal;
        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): self
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getAdresseComplement(): ?string
    {
        return $this->adresse_complement;
    }

    public function setAdresseComplement(?string $adresse_complement): self
    {
        $this->adresse_complement = $adresse_complement;
        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(?string $telephone): self
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function getClientNumber(): ?string
    {
        return $this->client_number;
    }

    public function setClientNumber(?string $client_number): self
    {
        $this->client_number = $client_number;
        return $this;
    }

    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): static
    {
        $this->is_active = $is_active;
        return $this;
    }

    public function getMagasin(): string
    {
        return $this->magasinEntity ? (string) $this->magasinEntity->getNom() : ($this->magasin ?? 'Client');
    }

    public function setMagasin(?string $magasin): self
    {
        $this->magasin = $magasin;
        return $this;
    }

    public function getMagasinEntity(): ?Magasin
    {
        return $this->magasinEntity;
    }

    public function setMagasinEntity(?Magasin $magasinEntity): self
    {
        $this->magasinEntity = $magasinEntity;
        if ($magasinEntity) {
            $this->magasin = $magasinEntity->getNom();
        }
        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(?string $photo): self
    {
        $this->photo = $photo;
        return $this;
    }

    public function getSignature(): ?string
    {
        return $this->signature;
    }

    public function setSignature(?string $signature): self
    {
        $this->signature = $signature;
        return $this;
    }

    public function getCalendarColor(): ?string
    {
        return $this->calendar_color;
    }

    public function setCalendarColor(?string $calendarColor): self
    {
        $this->calendar_color = $calendarColor;
        return $this;
    }

    public function isValidationHoraire(): bool
    {
        return $this->validation_horaire;
    }

    public function getValidationHoraire(): bool
    {
        return $this->validation_horaire;
    }

    public function setValidationHoraire(bool $validation_horaire): self
    {
        $this->validation_horaire = $validation_horaire;
        return $this;
    }

    public function isDemandeConge(): bool
    {
        return $this->demande_conge;
    }

    public function getDemandeConge(): bool
    {
        return $this->demande_conge;
    }

    public function setDemandeConge(bool $demande_conge): self
    {
        $this->demande_conge = $demande_conge;
        return $this;
    }

    public function isDocumentsRh(): bool
    {
        return $this->documents_rh;
    }

    public function getDocumentsRh(): bool
    {
        return $this->documents_rh;
    }

    public function setDocumentsRh(bool $documents_rh): self
    {
        $this->documents_rh = $documents_rh;
        return $this;
    }

    public function getRoleEntity(): ?Role
    {
        return $this->roleEntity;
    }

    public function setRoleEntity(?Role $roleEntity): self
    {
        $this->roleEntity = $roleEntity;
        if ($roleEntity) {
            $this->roles = [$roleEntity->getName()];
        }
        return $this;
    }

    public function getObservations(): Collection
    {
        return $this->observations;
    }

    public function addObservation(UserObservation $observation): static
    {
        if (!$this->observations->contains($observation)) {
            $this->observations->add($observation);
            $observation->setUser($this);
        }
        return $this;
    }

    public function removeObservation(UserObservation $observation): static
    {
        if ($this->observations->removeElement($observation)) {
            if ($observation->getUser() === $this) {
                $observation->setUser(null);
            }
        }
        return $this;
    }
}
