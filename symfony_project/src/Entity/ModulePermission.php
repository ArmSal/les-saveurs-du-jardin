<?php

namespace App\Entity;

use App\Repository\ModulePermissionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ModulePermissionRepository::class)]
#[ORM\UniqueConstraint(name: 'uniq_module_role', fields: ['moduleKey', 'roleName'])]
class ModulePermission
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $moduleKey = null;

    #[ORM\Column(length: 50)]
    private ?string $roleName = null;

    #[ORM\ManyToOne(inversedBy: 'permissions')]
    #[ORM\JoinColumn(nullable: true)]
    private ?Role $roleEntity = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $roleLabel = null;

    #[ORM\Column(length: 20)]
    private string $accessLevel = 'AUCUN_ACCES'; // AUCUN_ACCES, ACCES_TOTAL, ADMIN_MAGASIN, LECTURE_TOTALE, LECTURE_MAGASIN, ACCES_PERSONNEL

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getModuleKey(): ?string
    {
        return $this->moduleKey;
    }

    public function setModuleKey(string $moduleKey): static
    {
        $this->moduleKey = $moduleKey;
        return $this;
    }

    public function getRoleName(): ?string
    {
        return $this->roleName;
    }

    public function setRoleName(string $roleName): static
    {
        $this->roleName = $roleName;
        return $this;
    }

    public function getAccessLevel(): string
    {
        return $this->accessLevel;
    }

    public function setAccessLevel(string $accessLevel): static
    {
        $this->accessLevel = $accessLevel;
        return $this;
    }

    public function getRoleLabel(): ?string
    {
        return $this->roleLabel;
    }

    public function setRoleLabel(?string $roleLabel): static
    {
        $this->roleLabel = $roleLabel;
        return $this;
    }

    public function getRoleEntity(): ?Role
    {
        return $this->roleEntity;
    }

    public function setRoleEntity(?Role $roleEntity): static
    {
        $this->roleEntity = $roleEntity;
        if ($roleEntity) {
            $this->roleName = $roleEntity->getName();
            $this->roleLabel = $roleEntity->getLabel();
        }
        return $this;
    }
}
