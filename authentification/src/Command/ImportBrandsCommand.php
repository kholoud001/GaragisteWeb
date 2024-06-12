<?php
namespace App\Command;

use App\Entity\Mark;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportBrandsCommand extends Command
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
            ->setName('import:brands')
            ->setDescription('Import marks from JSON data file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Get the path to the JSON data file
        $jsonFilePath = $this->getApplication()->getKernel()->getProjectDir() . '/public/marks.json';

        // Check if the file exists
        if (!file_exists($jsonFilePath)) {
            $io->error('JSON file not found.');
            return Command::FAILURE;
        }

        // Read JSON data from file
        $jsonData = file_get_contents($jsonFilePath);

        if ($jsonData === false) {
            $io->error('Failed to read JSON data from file.');
            return Command::FAILURE;
        }

        // Decode JSON data
        $marks = json_decode($jsonData, true);

        if ($marks === null) {
            $io->error('Invalid JSON data.');
            return Command::FAILURE;
        }

        // Import marks
        foreach ($marks as $markData) {
            $mark = new Mark();
            $mark->setName($markData['name']);
            $this->entityManager->persist($mark);
        }

        $this->entityManager->flush();

        $io->success('Marks imported successfully.');
        return Command::SUCCESS;
    }
}
