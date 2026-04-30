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
    name: 'app:seed-bulk-users',
    description: 'Seed 5 accounts for every role (bulk operation)',
)]
class SeedBulkUsersCommand extends Command
{
    private array $rolesConfig = [
        'user1' => ['ROLE_USER'],
        'user2' => ['ROLE_USER'],
        'user3' => ['ROLE_USER'],
        'user4' => ['ROLE_USER'],
        'superadmin' => ['ROLE_DIRECTEUR'],
    ];

    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly UserPasswordHasherInterface $passwordHasher,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $count = 1;
        foreach ($this->rolesConfig as $prefix => $roleArray) {
            $passwordStr = $prefix . "12345!";
            $email = $prefix . "@lsdj.com";

            $user = new User();
            $user->setEmail($email);
            $user->setRoles($roleArray);
            $user->setCivility('Mr');
            $user->setNom(ucfirst($prefix));
            $user->setPrenom('System');
            $user->setPassword($this->passwordHasher->hashPassword($user, $passwordStr));
            $user->setClientNumber('CL-' . str_pad($count, 6, '0', STR_PAD_LEFT));

            $this->em->persist($user);
            $output->writeln("Created: $email with role " . implode(',', $roleArray));
            $count++;
        }

        $this->em->flush();
        $output->writeln('System accounts created successfully.');

        return Command::SUCCESS;
    }
}


