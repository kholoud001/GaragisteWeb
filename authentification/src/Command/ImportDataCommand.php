<?php
namespace App\Command;

use App\Entity\Mark;
use App\Entity\Model;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class ImportDataCommand extends Command
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
        ->setName('fill:import-data') 
        ->setDescription('Imports data from a JSON file into the database');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        
        $filePath = __DIR__ . '/../../public/carlist.json';

        if (!file_exists($filePath)) {
            $io->error('JSON file not found!');
            return Command::FAILURE;
        }

        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);

        foreach ($data as $item) {
            // Check if the mark already exists
            $mark = $this->entityManager->getRepository(Mark::class)->findOneBy(['name' => $item['brand']]);

            if (!$mark) {
                $mark = new Mark();
                $mark->setName($item['brand']);
                $this->entityManager->persist($mark);
            }

            foreach ($item['models'] as $modelName) {
                // Check if the model already exists for this mark
                $existingModel = $this->entityManager->getRepository(Model::class)->findOneBy([
                    'name' => $modelName,
                    'mark' => $mark
                ]);

                if (!$existingModel) {
                    $model = new Model();
                    $model->setName($modelName);
                    $model->setMark($mark);
                    $this->entityManager->persist($model);
                }
            }
        }

        $this->entityManager->flush();

        $io->success('Data imported successfully!');
        return Command::SUCCESS;
    }
}
