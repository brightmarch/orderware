<?php

namespace Orderware\AppBundle\Command;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class FeedCommand extends ContainerAwareCommand
{

    public function execute(InputInterface $input, OutputInterface $output)
    {
        return 0;
    }

    public function configure()
    {
        $this->setName('orderware:feed')
            ->addArgument('accounts', InputArgument::REQUIRED)
            ->addArgument('direction', InputArgument::REQUIRED)
            ->addArgument('feed-name', InputArgument::REQUIRED)
            ->addArgument('feed-file', InputArgument::OPTIONAL);

        return true;
    }

}
