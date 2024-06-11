<?php
namespace App\Command;

use App\Entity\Mark;
use App\Entity\Model;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FillEntitiesFromJsonCommand extends Command
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    protected function configure()
    {
        $this
            ->setName('fill:entities') 
            ->setDescription('Fill Mark and Model entities from JSON file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $jsonFilePath = $this->getApplication()->getKernel()->getProjectDir() . '/public/dataset_model_mark.json';

        $jsonData = file_get_contents($jsonFilePath);
        if ($jsonData === false) {
            $output->writeln('<error>Failed to read JSON file.</error>');
            return Command::FAILURE;
        }

        $data = json_decode($jsonData, true);
        if ($data === null) {
            $output->writeln('<error>Failed to decode JSON data.</error>');
            return Command::FAILURE;
        }

        foreach ($data as $item) {
            $markName = $item['mark'];
            $modelName = $item['model'];
           
            $mark = $this->entityManager->getRepository(Mark::class)->findOneBy(['name' => $markName]);
            if (!$mark) {
                $mark = new Mark();
                $mark->setName($markName);
                $this->entityManager->persist($mark);
            }

            $model = new Model();
            $model->setName($modelName);
            $model->setMark($mark);
            $this->entityManager->persist($model);
        }

        $this->entityManager->flush();

        $output->writeln('Entities filled successfully.');

        return Command::SUCCESS;
    }

}
