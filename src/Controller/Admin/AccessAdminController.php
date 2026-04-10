<?php

namespace App\Controller\Admin;

use App\Entity\Role;
use App\Repository\RoleRepository;
use App\Entity\Magasin;
use App\Repository\MagasinRepository;
use App\Entity\ModulePermission;
use App\Repository\ModulePermissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Service\AccessHelper;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/access')]
class AccessAdminController extends AbstractController
{
    private AccessHelper $access;

    public function __construct(AccessHelper $access)
    {
        $this->access = $access;
    }

    private array $modules = [
        'dashboard' => 'Tableau de Bord',
        'agenda' => 'Planning / Agenda',
        'user_observations' => 'Observations Employés',
        'users' => 'Gestion du personnel',
        'rh_validation' => 'Validation des Horaires',
        'rh_conge' => 'Demande de Congé',
        'rh_documents' => 'Documents RH & Contrats',
        'documents' => 'Documents Généraux',
        'transport_logistique' => 'Transport & Logistique',
        'maintenance_signalement' => 'Signalement Matériel',
        'maintenance_suivi' => 'Suivi Intervention',
        'produits' => 'Produits',
        'commandes' => 'Gestion Commandes',
        'shortcuts' => 'Raccourcis Dashboard',
        'access_management' => 'Gestion des Accès',
    ];

    #[Route('', name: 'admin_access_index')]
    public function index(ModulePermissionRepository $permRepo, RoleRepository $roleRepo, EntityManagerInterface $em): Response
    {
        if (!$this->access->canView('access_management')) {
            throw $this->createAccessDeniedException();
        }

        $roles = $roleRepo->findAllOrdered();
        $allPermissions = $permRepo->findAll();

        // Group permissions by module and role for easy lookup in template
        $matrix = [];
        foreach ($allPermissions as $p) {
            $matrix[$p->getModuleKey()][$p->getRoleName()] = $p->getAccessLevel();
        }

        return $this->render('admin/access/index.html.twig', [
            'modules' => $this->modules,
            'roles' => $roles,
            'matrix' => $matrix,
            'magasins' => $em->getRepository(Magasin::class)->findAll(),
            'accessLevels' => ['AUCUN_ACCES', 'ACCES_TOTAL', 'ADMIN_MAGASIN', 'LECTURE_TOTALE', 'LECTURE_MAGASIN', 'ACCES_PERSONNEL'],
        ]);
    }

    #[Route('/update', name: 'admin_access_update', methods: ['POST'])]
    public function update(Request $request, EntityManagerInterface $em, ModulePermissionRepository $permRepo, RoleRepository $roleRepo): JsonResponse
    {
        if (!$this->access->canEdit('access_management')) {
            return new JsonResponse(['error' => 'Forbidden'], 403);
        }

        $data = json_decode($request->getContent(), true);
        $moduleKey = $data['moduleKey'] ?? null;
        $roleName = $data['roleName'] ?? null;
        $accessLevel = $data['accessLevel'] ?? null;

        if (!$moduleKey || !$roleName || !$accessLevel) {
            return new JsonResponse(['error' => 'Missing data'], 400);
        }

        // Special restriction for documents
        if ($moduleKey === 'documents' && in_array($accessLevel, ['ADMIN_MAGASIN', 'LECTURE_MAGASIN', 'ACCES_PERSONNEL'])) {
            return new JsonResponse(['error' => 'Ce niveau d\'accès n\'est pas applicable pour ce module.'], 403);
        }
        
        // Special restriction for access_management, dashboard
        if (in_array($moduleKey, ['access_management', 'dashboard']) && in_array($accessLevel, ['LECTURE_TOTALE', 'LECTURE_MAGASIN', 'ADMIN_MAGASIN', 'ACCES_PERSONNEL'])) {
            return new JsonResponse(['error' => 'Ce niveau d\'accès n\'est pas applicable pour ce module.'], 403);
        }

        // Special restriction for user_observations: only AUCUN_ACCES, ADMIN_MAGASIN, ACCES_TOTAL
        if ($moduleKey === 'user_observations' && in_array($accessLevel, ['LECTURE_TOTALE', 'LECTURE_MAGASIN', 'ACCES_PERSONNEL'])) {
            return new JsonResponse(['error' => 'Ce niveau d\'accès n\'est pas applicable pour ce module.'], 403);
        }

        // Special restriction for transport_logistique - only AUCUN_ACCES and ACCES_TOTAL
        if ($moduleKey === 'transport_logistique' && in_array($accessLevel, ['LECTURE_TOTALE', 'LECTURE_MAGASIN', 'ADMIN_MAGASIN', 'ACCES_PERSONNEL'])) {
            return new JsonResponse(['error' => 'Ce niveau d\'accès n\'est pas applicable pour ce module.'], 403);
        }

        // Special restriction for maintenance_suivi - only AUCUN_ACCES, ACCES_TOTAL, and ACCES_PERSONNEL
        if ($moduleKey === 'maintenance_suivi' && in_array($accessLevel, ['LECTURE_TOTALE', 'LECTURE_MAGASIN', 'ADMIN_MAGASIN'])) {
            return new JsonResponse(['error' => 'Ce niveau d\'accès n\'est pas applicable pour ce module.'], 403);
        }

        // Special restriction for rh_conge and rh_documents: block LECTURE levels
        if (in_array($moduleKey, ['rh_conge', 'rh_documents']) && in_array($accessLevel, ['LECTURE_TOTALE', 'LECTURE_MAGASIN'])) {
            return new JsonResponse(['error' => 'Ce niveau d\'accès n\'est pas applicable pour ce module.'], 403);
        }

        if ($roleName === 'ROLE_DIRECTEUR') {
            return new JsonResponse(['error' => 'L\'accès de ce rôle est fixe ou géré par le système.'], 403);
        }

        $permission = $permRepo->findOneBy(['moduleKey' => $moduleKey, 'roleName' => $roleName]);
        $role = $roleRepo->findOneBy(['name' => $roleName]);

        if (!$permission) {
            $permission = new ModulePermission();
            $permission->setModuleKey($moduleKey);
            $permission->setRoleName($roleName);
            if ($role) {
                $permission->setRoleEntity($role);
            }
            $em->persist($permission);
        }

        $permission->setAccessLevel($accessLevel);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/role/add', name: 'admin_access_role_add', methods: ['POST'])]
    public function addRole(Request $request, EntityManagerInterface $em): JsonResponse
    {
        if (!$this->access->canEdit('access_management')) {
            return new JsonResponse(['error' => 'Forbidden'], 403);
        }

        $data = json_decode($request->getContent(), true);
        $name = $data['name'] ?? null;
        $label = $data['label'] ?? null;
        $isContact = $data['isContact'] ?? false;

        if (!$name || !$label) {
            return new JsonResponse(['error' => 'Missing data'], 400);
        }

        // Ensure name starts with ROLE_
        if (!str_starts_with(strtoupper($name), 'ROLE_')) {
            $name = 'ROLE_' . strtoupper($name);
        } else {
            $name = strtoupper($name);
        }

        // Check if role already exists
        $existing = $em->getRepository(Role::class)->findOneBy(['name' => $name]);
        if ($existing) {
            return new JsonResponse(['error' => 'Ce rôle existe déjà'], 400);
        }

        $role = new Role();
        $role->setName($name);
        $role->setLabel($label);
        $role->setIsContact((bool) $isContact);
        $role->setPriority(99);
        $em->persist($role);

        // Create a record for each module
        foreach ($this->modules as $modKey => $modLabel) {
            $permission = new ModulePermission();
            $permission->setModuleKey($modKey);
            $permission->setRoleEntity($role);
            $permission->setAccessLevel('AUCUN_ACCES');
            $em->persist($permission);
        }

        $em->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/role/edit/{id}', name: 'admin_access_role_edit', methods: ['POST'])]
    public function editRole(Role $role, Request $request, EntityManagerInterface $em): JsonResponse
    {
        if (!$this->access->canEdit('access_management')) {
            return new JsonResponse(['error' => 'Forbidden'], 403);
        }

        $data = json_decode($request->getContent(), true);
        $label = $data['label'] ?? null;
        $isContact = $data['isContact'] ?? false;

        if (!$label) {
            return new JsonResponse(['error' => 'Label manquant'], 400);
        }

        $role->setLabel($label);
        $role->setIsContact((bool) $isContact);
        
        // Propagate to permissions for backward compat if needed (though already done in setter)
        foreach ($role->getPermissions() as $p) {
            $p->setRoleLabel($label);
        }

        $em->flush();
        return new JsonResponse(['success' => true]);
    }

    #[Route('/role/delete/{id}', name: 'admin_access_role_delete', methods: ['POST', 'DELETE'])]
    public function deleteRole(Role $role, EntityManagerInterface $em): JsonResponse
    {
        if (!$this->access->canEdit('access_management')) {
            return new JsonResponse(['error' => 'Forbidden'], 403);
        }

        if ($role->getName() === 'ROLE_DIRECTEUR') {
            return new JsonResponse(['error' => 'Vous ne pouvez pas supprimer le rôle système principal.'], 403);
        }

        // Check if any user has this role
        if (count($role->getUsers()) > 0) {
            return new JsonResponse([
                'error' => sprintf('Impossible, %d utilisateurs utilisent ce rôle', count($role->getUsers()))
            ], 400);
        }

        $em->remove($role);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/magasin/add', name: 'admin_access_magasin_add', methods: ['POST'])]
    public function addMagasin(Request $request, EntityManagerInterface $em): JsonResponse
    {
        if (!$this->access->canEdit('access_management')) {
            return new JsonResponse(['error' => 'Forbidden'], 403);
        }

        $data = json_decode($request->getContent(), true);
        $nom = $data['nom'] ?? null;

        if (!$nom) {
            return new JsonResponse(['error' => 'Nom manquant'], 400);
        }

        $magasin = new Magasin();
        $magasin->setNom($nom);
        $magasin->setIsActive(true);
        $em->persist($magasin);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/magasin/edit/{id}', name: 'admin_access_magasin_edit', methods: ['POST'])]
    public function editMagasin(Magasin $magasin, Request $request, EntityManagerInterface $em): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $nom = $data['nom'] ?? null;

        if (!$nom) {
            return new JsonResponse(['error' => 'Le nom est requis.'], 400);
        }

        $magasin->setNom($nom);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }

    #[Route('/magasin/delete/{id}', name: 'admin_access_magasin_delete', methods: ['POST', 'DELETE'])]
    public function deleteMagasin(Magasin $magasin, EntityManagerInterface $em): JsonResponse
    {
        if (!$this->access->canEdit('access_management')) {
            return new JsonResponse(['error' => 'Forbidden'], 403);
        }

        if (count($magasin->getUsers()) > 0) {
            return new JsonResponse(['error' => 'Impossible de supprimer un magasin qui contient des utilisateurs'], 400);
        }

        $em->remove($magasin);
        $em->flush();

        return new JsonResponse(['success' => true]);
    }
}
