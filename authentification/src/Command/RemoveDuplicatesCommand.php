<?php
namespace App\Command;

use App\Entity\Mark;
use App\Entity\Model;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class RemoveDuplicatesCommand extends Command
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setName('remove:duplicates')
            ->setDescription('Removes duplicate entries from the mark and model tables');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $this->updateModels($io);
        $this->removeDuplicateMarks($io);

        $io->success('Duplicates removed successfully!');
        return Command::SUCCESS;
    }

    private function updateModels(SymfonyStyle $io)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('m.name, MIN(m.id) as min_id')
            ->from(Mark::class, 'm')
            ->groupBy('m.name')
            ->having('COUNT(m.id) > 1');

        $duplicateMarks = $qb->getQuery()->getResult();

        foreach ($duplicateMarks as $duplicate) {
            $minId = $duplicate['min_id'];

            // Update models to reference the unique mark
            $this->entityManager->createQuery('UPDATE App\Entity\Model md SET md.mark = :minId WHERE md.mark IN (SELECT m.id FROM App\Entity\Mark m WHERE m.name = :name AND m.id != :minId)')
                ->setParameter('minId', $minId)
                ->setParameter('name', $duplicate['name'])
                ->execute();
        }

        $io->success('Models updated successfully!');
    }

    private function removeDuplicateMarks(SymfonyStyle $io)
    {
        $qb = $this->entityManager->createQueryBuilder();
        $qb->select('m.name, MIN(m.id) as min_id')
            ->from(Mark::class, 'm')
            ->groupBy('m.name')
            ->having('COUNT(m.id) > 1');

        $duplicateMarks = $qb->getQuery()->getResult();

        foreach ($duplicateMarks as $duplicate) {
            $name = $duplicate['name'];
            $minId = $duplicate['min_id'];

            // Delete duplicate marks
            $this->entityManager->createQuery('DELETE FROM App\Entity\Mark m WHERE m.name = :name AND m.id != :minId')
                ->setParameter('minId', $minId)
                ->setParameter('name', $name)
                ->execute();

            $io->success("Processed mark: $name");
        }
    }
}
