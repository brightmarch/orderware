<?php

namespace Orderware\AppBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use \InvalidArgumentException;

class ProcessFeedCommand extends ContainerAwareCommand
{

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $feedId = $input->getArgument('feed-id');

        $feed = $this->getContainer()
            ->get('doctrine')
            ->getManager('orderware')
            ->getRepository('Orderware:Feed')
            ->find((int)$feedId);

        if (!$feed) {
            throw new InvalidArgumentException(sprintf("The feed (%s) could not be found.", $feedId));
        }

        $factory = $this->getContainer()
            ->get('orderware.feed_processor_factory');

        $factory->build($feed)
            ->run($feed);

        $output->writeln(
            sprintf('<info>Successfully processed feed "%s" (%d) with %d records in %d seconds.</info>', $feed, $feed->getFeedId(), $feed->getRecordCount(), $feed->getRunTime())
        );

        return 0;
    }

    public function configure()
    {
        $this->setName('orderware:process-feed')
            ->addArgument('feed-id', InputArgument::REQUIRED, "The feed.feed_id of the feed to process.")
            ->setDescription("Processes a feed that has already been imported.");

        return true;
    }

}
