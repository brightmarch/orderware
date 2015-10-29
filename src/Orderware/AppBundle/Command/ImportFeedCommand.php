<?php

namespace Orderware\AppBundle\Command;

use Orderware\AppBundle\Entity\Feed;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportFeedCommand extends ContainerAwareCommand
{

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $importer = $this->getContainer()
            ->get('orderware.feed_importer');

        $feed = $importer->import(
            $input->getArgument('manifest'),
            $input->getArgument('feed')
        );

        $output->writeln(sprintf('<info>Successfully created feed "%s" (%d).</info>', $feed, $feed->getFeedId()));

        return 0;
    }

    public function configure()
    {
        $this->setName('orderware:import-feed')
            ->addArgument('manifest', InputArgument::REQUIRED, "The manifest.json file that describes the feed.")
            ->addArgument('feed', InputArgument::REQUIRED, "The feed file that contains the data to process.")
            ->setDescription("Imports a manifest and feed file to be processed.");

        return true;
    }

}
