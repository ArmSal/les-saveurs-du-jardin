<?php

namespace App\Command;

use App\Repository\PortalHoraireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(
    name: 'app:lock-hours',
    description: 'Lock hours older than 6 weeks',
)]
class LockHoursCommand extends Command
{
    private $horaireRepo;
    private $em;

    public function __construct(PortalHoraireRepository $horaireRepo, EntityManagerInterface $em)
    {
        $this->horaireRepo = $horaireRepo;
        $this->em = $em;
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        // Calculate the threshold: Monday of the week 6 weeks ago
        $now = new \DateTime();
        $currentWeek = (int)$now->format('W');
        $currentYear = (int)$now->format('Y');
        
        $thresholdDate = new \DateTime();
        // We want to lock everything from weeks before W-6
        // If today is W10, we lock W4 and older.
        // W10 -> W9, W8, W7, W6, W5 (allowed) -> W4 (locked)
        // 10 - 6 = 4.
        
        // Let's just use a simple relative date: 6 weeks ago from today's Monday
        $mondayThisWeek = clone $now;
        $mondayThisWeek->setISODate($currentYear, $currentWeek, 1);
        $mondayThisWeek->setTime(0, 0, 0);
        
        $lockThreshold = clone $mondayThisWeek;
        $lockThreshold->modify('-6 weeks'); 

        $qb = $this->horaireRepo->createQueryBuilder('h')
            ->where('h.startTime < :threshold')
            ->andWhere('h.isLocked = :locked')
            ->setParameter('threshold', $lockThreshold)
            ->setParameter('locked', false);
            
        $hoursToLock = $qb->getQuery()->getResult();
        
        $count = count($hoursToLock);
        foreach ($hoursToLock as $h) {
            $h->setLocked(true);
        }
        
        $this->em->flush();

        $io->success(sprintf('Successfully locked %d hour entries older than 6 weeks (threshold: %s).', $count, $lockThreshold->format('Y-m-d')));

        return Command::SUCCESS;
    }
}
