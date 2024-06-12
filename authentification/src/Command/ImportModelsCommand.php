<?php
namespace App\Command;

use App\Entity\Model;
use App\Repository\MarkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportModelsCommand extends Command
{
    private $entityManager;
    private $markRepository;

    public function __construct(EntityManagerInterface $entityManager, MarkRepository $markRepository)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->markRepository = $markRepository;
    }

    protected function configure()
    {
        $this
            ->setName('import:models')
            ->setDescription('Import models from JSON data file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Get the path to the JSON data file
        $jsonFilePath = $this->getApplication()->getKernel()->getProjectDir() . '/public/models.json';

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
        $models = json_decode($jsonData, true);

        if ($models === null) {
            $io->error('Invalid JSON data.');
            return Command::FAILURE;
        }

        // Import models
        foreach ($models as $modelData) {
            $markName = $modelData['mark']['name'];
            $mark = $this->markRepository->findOneBy(['name' => $markName]);
            
            if (!$mark) {
                $io->warning("Mark '$markName' not found for model '{$modelData['name']}'. Skipping.");
                continue;
            }

            $model = new Model();
            $model->setName($modelData['name']);
            $model->setMark($mark);
            $this->entityManager->persist($model);
        }

        $this->entityManager->flush();

        $io->success('Models imported successfully.');
        return Command::SUCCESS;
    }
}
