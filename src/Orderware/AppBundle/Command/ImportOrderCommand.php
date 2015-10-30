<?php

namespace Orderware\AppBundle\Command;

use Orderware\AppBundle\Entity\OrdImport;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

class ImportOrderCommand extends ContainerAwareCommand
{

    public function execute(InputInterface $input, OutputInterface $output)
    {
        return 0;
    }

    public function configure()
    {
        $this->setName('orderware:import-order')
            ->addArgument('order', InputArgument::REQUIRED, "The order JSON file that describes the order.")
            ->setDescription("Imports an order into Orderware.");

        return true;
    }

}
