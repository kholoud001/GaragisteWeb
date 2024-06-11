<?php

namespace App\Command;

use App\Entity\Part;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FillPartsFromJsonCommand extends Command
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
            ->setName('fill:partsEntity') 
            ->setDescription('Fill Part entities from JSON file');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $jsonFilePath = $this->getApplication()->getKernel()->getProjectDir() . '/public/parts.json';

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
            $partName = $item['name'];

            // Create Part entity
            $part = new Part();
            $part->setName($partName);
            $this->entityManager->persist($part);
        }

        $this->entityManager->flush();

        $output->writeln('Parts filled successfully.');

        return Command::SUCCESS;
    }
}
