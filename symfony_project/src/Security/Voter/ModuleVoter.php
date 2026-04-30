<?php

namespace App\Security\Voter;

use App\Entity\User;
use App\Repository\ModulePermissionRepository;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\User\UserInterface;

class ModuleVoter extends Voter
{
    public const VIEW = 'MODULE_VIEW';
    public const EDIT = 'MODULE_EDIT';

    private ModulePermissionRepository $permRepo;

    public function __construct(ModulePermissionRepository $permRepo)
    {
        $this->permRepo = $permRepo;
    }

    protected function supports(string $attribute, mixed $subject): bool
    {
        return in_array($attribute, [self::VIEW, self::EDIT]) && is_string($subject);
    }

    protected function voteOnAttribute(string $attribute, mixed $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        if (!$user instanceof User) {
            return false;
        }

        $moduleKey = $subject;
        $roles = $user->getRoles();
        if (in_array('ROLE_DIRECTEUR', $roles)) {
            return true;
        }
        
        // Find the "best" access level across all user roles
        $bestLevel = 'AUCUN_ACCES';
        foreach ($roles as $role) {
            $perm = $this->permRepo->getPermission($moduleKey, $role);
            if ($perm) {
                $level = $perm->getAccessLevel();
                $bestLevel = $this->compareLevels($bestLevel, $level);
            }
        }

        if ($bestLevel === 'AUCUN_ACCES') {
            return false;
        }

        if ($attribute === self::VIEW) {
            // All non-AUCUN levels can view — matches AccessHelper::canView()
            return in_array($bestLevel, ['ACCES_TOTAL', 'ADMIN_MAGASIN', 'LECTURE_TOTALE', 'LECTURE_MAGASIN', 'ACCES_PERSONNEL']);
        }

        if ($attribute === self::EDIT) {
            return in_array($bestLevel, ['ACCES_TOTAL', 'ADMIN_MAGASIN']);
        }

        return false;
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
