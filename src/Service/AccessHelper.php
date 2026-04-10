<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\ModulePermissionRepository;
use Symfony\Bundle\SecurityBundle\Security;

class AccessHelper
{
    private Security $security;
    private ModulePermissionRepository $permRepo;

    public function __construct(Security $security, ModulePermissionRepository $permRepo)
    {
        $this->security = $security;
        $this->permRepo = $permRepo;
    }

    public function getAccessLevel(string $moduleKey, ?User $user = null): string
    {
        if (!$user) {
            $user = $this->security->getUser();
        }
        
        if (!$user instanceof User) {
            return 'AUCUN_ACCES';
        }

        $roles = $user->getRoles();
        if (in_array('ROLE_DIRECTEUR', $roles)) {
            return 'ACCES_TOTAL';
        }
        
        $bestLevel = 'AUCUN_ACCES';
        
        foreach ($roles as $role) {
            $perm = $this->permRepo->getPermission($moduleKey, $role);
            if ($perm) {
                $bestLevel = $this->compareLevels($bestLevel, $perm->getAccessLevel());
            }
        }

        return $bestLevel;
    }

    public function canView(string $moduleKey, ?User $user = null): bool
    {
        $level = $this->getAccessLevel($moduleKey, $user);
        return in_array($level, ['ACCES_TOTAL', 'ADMIN_MAGASIN', 'LECTURE_TOTALE', 'LECTURE_MAGASIN', 'ACCES_PERSONNEL']);
    }

    public function canEdit(string $moduleKey, ?User $user = null): bool
    {
        $level = $this->getAccessLevel($moduleKey, $user);
        return in_array($level, ['ACCES_TOTAL', 'ADMIN_MAGASIN']);
    }

    public function isFullView(string $moduleKey, ?User $user = null): bool
    {
        $level = $this->getAccessLevel($moduleKey, $user);
        return $level === 'LECTURE_TOTALE' || $level === 'ACCES_TOTAL';
    }

    public function isFullAccess(string $moduleKey, ?User $user = null): bool
    {
        return $this->getAccessLevel($moduleKey, $user) === 'ACCES_TOTAL';
    }

    public function isMagasinOnly(string $moduleKey, ?User $user = null): bool
    {
        $level = $this->getAccessLevel($moduleKey, $user);
        return in_array($level, ['ADMIN_MAGASIN', 'LECTURE_MAGASIN']);
    }

    public function isPersonalAccess(string $moduleKey, ?User $user = null): bool
    {
        $level = $this->getAccessLevel($moduleKey, $user);
        return $level === 'ACCES_PERSONNEL';
    }

    private function compareLevels(string $current, string $new): string
    {
        $priority = [
            'ACCES_TOTAL' => 5,
            'ADMIN_MAGASIN' => 4,
            'LECTURE_TOTALE' => 3,
            'LECTURE_MAGASIN' => 2,
            'ACCES_PERSONNEL' => 1,
            'AUCUN_ACCES' => 0,
        ];

        return ($priority[$new] > $priority[$current]) ? $new : $current;
    }
}
