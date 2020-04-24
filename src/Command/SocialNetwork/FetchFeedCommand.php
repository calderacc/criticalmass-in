<?php

namespace App\Command\SocialNetwork;

use App\Criticalmass\SocialNetwork\FeedFetcher\FeedFetcher;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchFeedCommand extends Command
{
    /** @var FeedFetcher $feedFetcher */
    protected $feedFetcher;

    /** @var ManagerRegistry $doctrine */
    protected $doctrine;

    public function __construct(ManagerRegistry $doctrine, FeedFetcher $feedFetcher)
    {
        $this->doctrine = $doctrine;
        $this->feedFetcher = $feedFetcher;

        parent::__construct(null);

    }

    protected function configure(): void
    {
        $this
            ->setName('criticalmass:social-network:fetch-feed')
            ->setDescription('Fetch feeds')
            ->addArgument('networks', InputArgument::IS_ARRAY);
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        if ($input->hasArgument('networks')) {
            foreach ($input->getArgument('networks') as $network) {
                $this->feedFetcher->addFetchableNetwork($network);
            }
        }

        $this->feedFetcher->fetch()->persist();
    }
}
