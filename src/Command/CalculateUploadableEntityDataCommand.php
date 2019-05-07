<?php declare(strict_types=1);

namespace App\Command;

use App\Criticalmass\Image\GoogleCloud\ExportDataHandler\ExportDataHandlerInterface;
use App\Criticalmass\UploadableDataHandler\UploadableDataHandlerInterface;
use App\Entity\Photo;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CalculateUploadableEntityDataCommand extends Command
{
    /** @var RegistryInterface $registry */
    protected $registry;

    /** @var UploadableDataHandlerInterface $uploadableDataHandler */
    protected $uploadableDataHandler;

    public function __construct(RegistryInterface $registry, UploadableDataHandlerInterface $uploadableDataHandler)
    {
        $this->registry = $registry;
        $this->uploadableDataHandler = $uploadableDataHandler;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName('criticalmass:calculate-uploadable-meta')
            ->setDescription('Calculate meta for uploadable entities')
            ->addOption('limit', 'l', InputOption::VALUE_REQUIRED, 'Number of photos to process at once')
            ->addOption('offset', 'o', InputOption::VALUE_REQUIRED, 'Offset to start processing')
            ->addArgument('entityClassname', InputArgument::REQUIRED, 'Classname of entity');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $limit = $input->getOption('limit') ? (int) $input->getOption('limit') : null;
        $offset = $input->getOption('offset') ? (int) $input->getOption('offset') : null;
        $entityClassname = $input->getArgument('entityClassname');
        $fqcn = $this->getFqcn($entityClassname);

        $entityList = $this->registry->getRepository($fqcn)->findBy([], [], $limit, $offset);

        $progressBar = new ProgressBar($output, count($entityList));

        foreach ($entityList as $entity) {
            $this->uploadableDataHandler->calculateForEntity($entity);

            $progressBar->advance();
        }

        $this->registry->getManager()->flush();
        $progressBar->finish();
    }

    protected function getFqcn(string $classname): string
    {
        return sprintf('App\\Entity\\%s', $classname);
    }
}
