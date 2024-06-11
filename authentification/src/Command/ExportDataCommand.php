<?php
namespace App\Command;

use App\Entity\Mark;
use App\Entity\Model;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Serializer\SerializerInterface;

class ExportDataCommand extends Command
{
    private $entityManager;
    private $serializer;

    public function __construct(EntityManagerInterface $entityManager, SerializerInterface $serializer)
    {
        parent::__construct();
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
    }

    protected function configure()
    {
        $this
            ->setName('export:data')
            ->setDescription('Exports data from the mark and model tables to JSON files');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Export marks to JSON
        $marks = $this->entityManager->getRepository(Mark::class)->findAll();
        $this->exportToJson('marks.json', $marks);

        // Export models to JSON
        $models = $this->entityManager->getRepository(Model::class)->findAll();
        $this->exportToJson('models.json', $models);

        $io->success('Data exported successfully to JSON files!');
        return Command::SUCCESS;
    }

    private function exportToJson(string $filename, array $data)
    {
        $jsonData = $this->serializer->serialize($data, 'json');

        file_put_contents($filename, $jsonData);
    }
}
