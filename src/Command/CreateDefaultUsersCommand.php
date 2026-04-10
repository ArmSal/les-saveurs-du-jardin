<?php

namespace App\Command;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-default-users',
    description: 'Create default users for USER/EMPLOYE/ADMIN/MASTER_ADMIN/SUPER_ADMIN roles',
)]
class CreateDefaultUsersCommand extends Command
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $defaults = [
            [
                'email' => 'user1@platform.local',
                'password' => 'User12345!',
                'roles' => ['ROLE_USER'],
            ],
            [
                'email' => 'user2@platform.local',
                'password' => 'User12345!',
                'roles' => ['ROLE_USER'],
            ],
            [
                'email' => 'user3@platform.local',
                'password' => 'User12345!',
                'roles' => ['ROLE_USER'],
            ],
            [
                'email' => 'superadmin@platform.local',
                'password' => 'SuperAdmin12345!',
                'roles' => ['ROLE_DIRECTEUR'],
            ],
        ];

        foreach ($defaults as $data) {
            $existing = $this->em->getRepository(User::class)->findOneBy(['email' => $data['email']]);
            if ($existing) {
                $output->writeln(sprintf('Skipped (exists): %s', $data['email']));
                continue;
            }

            $user = new User();
            $user->setEmail($data['email']);
            $user->setRoles($data['roles']);
            $user->setPassword($this->passwordHasher->hashPassword($user, $data['password']));

            $this->em->persist($user);
            $output->writeln(sprintf('Created: %s (%s)', $data['email'], implode(',', $data['roles'])));
        }

        $this->em->flush();

        $output->writeln('Done.');

        return Command::SUCCESS;
    }
}


