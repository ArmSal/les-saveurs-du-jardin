<?php

namespace App\Repository;

use App\Entity\ModulePermission;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ModulePermission>
 */
class ModulePermissionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ModulePermission::class);
    }

    public function getPermission(string $moduleKey, string $roleName): ?ModulePermission
    {
        return $this->findOneBy([
            'moduleKey' => $moduleKey,
            'roleName' => $roleName,
        ]);
    }

    /**
     * @return array<int, array{roleName: string, roleLabel: string}>
     */
    public function findAllRoles(): array
    {
        return $this->createQueryBuilder('mp')
            ->select('DISTINCT mp.roleName, mp.roleLabel')
            ->orderBy('mp.roleName', 'ASC')
            ->getQuery()
            ->getArrayResult();
    }
}
