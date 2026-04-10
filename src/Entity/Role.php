<?php

namespace App\Entity;

use App\Repository\RoleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RoleRepository::class)]
class Role
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    private ?string $name = null;

    #[ORM\Column(length: 100)]
    private ?string $label = null;

    #[ORM\Column(options: ["default" => 99])]
    private int $priority = 99;

    #[ORM\Column(type: 'boolean', options: ["default" => false])]
    private bool $isContact = false;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(mappedBy: 'roleEntity', targetEntity: User::class)]
    private Collection $users;

    /**
     * @var Collection<int, ModulePermission>
     */
    #[ORM\OneToMany(mappedBy: 'roleEntity', targetEntity: ModulePermission::class, cascade: ['remove'], orphanRemoval: true)]
    private Collection $permissions;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->permissions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = strtoupper($name);
        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;
        return $this;
    }

    public function getPriority(): int
    {
        return $this->priority;
    }

    public function setPriority(int $priority): static
    {
        $this->priority = $priority;
        return $this;
    }

    public function isContact(): bool
    {
        return $this->isContact;
    }

    public function setIsContact(bool $isContact): static
    {
        $this->isContact = $isContact;
        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setRoleEntity($this);
        }
        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getRoleEntity() === $this) {
                $user->setRoleEntity(null);
            }
        }
        return $this;
    }

    /**
     * @return Collection<int, ModulePermission>
     */
    public function getPermissions(): Collection
    {
        return $this->permissions;
    }

    public function addPermission(ModulePermission $permission): static
    {
        if (!$this->permissions->contains($permission)) {
            $this->permissions->add($permission);
            $permission->setRoleEntity($this);
        }
        return $this;
    }

    public function removePermission(ModulePermission $permission): static
    {
        if ($this->permissions->removeElement($permission)) {
            // set the owning side to null (unless already changed)
            if ($permission->getRoleEntity() === $this) {
                $permission->setRoleEntity(null);
            }
        }
        return $this;
    }
}
