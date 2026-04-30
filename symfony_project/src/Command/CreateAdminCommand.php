<?php

namespace App\Command;

use App\Entity\Magasin;
use App\Entity\Role;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-admin',
    description: 'Creates a default Directeur user with all rights',
)]
class CreateAdminCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        // 1. Ensure Magasin exists
        $magasin = $this->entityManager->getRepository(Magasin::class)->findOneBy(['nom' => 'LSDJ']);
        if (!$magasin) {
            $magasin = new Magasin();
            $magasin->setNom('LSDJ');
            $magasin->setIsActive(true);
            $this->entityManager->persist($magasin);
            $io->info('Created default Magasin: LSDJ');
        }

        // 2. Ensure Role exists
        $roleName = 'ROLE_DIRECTEUR';
        $role = $this->entityManager->getRepository(Role::class)->findOneBy(['name' => $roleName]);
        if (!$role) {
            $role = new Role();
            $role->setName($roleName);
            $role->setLabel('Directeur Général');
            $role->setPriority(1);
            $this->entityManager->persist($role);
            $io->info('Created default Role: ROLE_DIRECTEUR');
        }

        // 3. Ensure User exists
        $email = 'directeur@lsj.fr';
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user) {
            $io->note(sprintf('User %s already exists', $email));
            
            // Still ensure it has the right role if it exists
            $user->setRoleEntity($role);
            $user->setRoles([$roleName]);
        } else {
            $user = new User();
            $user->setEmail($email);
            $user->setNom('DIRECTEUR');
            $user->setPrenom('Admin');
            $user->setCivility('Mr');
            $user->setIsActive(true);
            $user->setMagasinEntity($magasin);
            $user->setRoleEntity($role);
            $user->setRoles([$roleName]);

            $hashedPassword = $this->passwordHasher->hashPassword($user, 'admin123');
            $user->setPassword($hashedPassword);

            $this->entityManager->persist($user);
            $io->success(sprintf('User %s was successfully created with password "admin123"', $email));
        }

        $this->entityManager->flush();

        return Command::SUCCESS;
    }
}
