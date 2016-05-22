<?php

namespace Orderware\AppBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ProcessFeedCommand extends ContainerAwareCommand
{

    /** @var string */
    const SEPARATOR = ',';

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // Get a list of accounts to operate on.
        $accounts = $input->getArgument('accounts');
        $accounts = explode(self::SEPARATOR, $accounts);

        // And get the other required arguments.
        $direction = strtolower($input->getArgument('direction'));
        $feedName = strtolower($input->getArgument('feed-name'));

        $processor = $this->getContainer()
            ->get('orderware.feed_processor');

        // Associate a local file with this feed.
        $processor->setLocalFile(
            $input->getArgument('feed-file')
        );

        foreach ($accounts as $account) {
            $processor->process($account, $direction, $feedName);
        }

        return 0;
    }

    public function configure()
    {
        $this->setName('orderware:process-feed')
            ->addArgument('accounts', InputArgument::REQUIRED)
            ->addArgument('direction', InputArgument::REQUIRED)
            ->addArgument('feed-name', InputArgument::REQUIRED)
            ->addArgument('feed-file', InputArgument::OPTIONAL);

        return true;
    }

}
