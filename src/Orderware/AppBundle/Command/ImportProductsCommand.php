<?php

namespace Orderware\AppBundle\Command;

use Orderware\AppBundle\Entity\Feed;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use \InvalidArgumentException,
    \RuntimeException;

class ImportProductsCommand extends ContainerAwareCommand
{

    public function execute(InputInterface $input, OutputInterface $output)
    {
        // Ensure the division actually exists.
        $_em = $this->getContainer()
            ->get('doctrine')
            ->getManager('orderware');

        $division = $_em->getRepository('Orderware:Division')
            ->findOneByDivision($division);

        if (!$division) {
            throw new InvalidArgumentException(sprintf("The division (%s) does not exist.", $division));
        }

        // Ensure the division is enabled.
        if (!$division->isEnabled()) {
            throw new RuntimeException(sprintf("The division (%s) is not enabled.", $division));
        }

        // Ensure the path to the feed file is valid.

        // Get the corresponding XSD to validate the feed against.
        // Validate the feed file against the XSD. Report any errors and stop.

        // Get the vendors from the feed file and search to see
        // if it already exists by the vendor num.
        // Hydrate the vendor entity (whether new or not).
        // Validate the entity. Report any errors and stop processing.
        // Persist and flush the entity to the database.

        return 0;
    }

    public function configure()
    {
        $this->setName('orderware:import-products')
            ->addArgument('division', InputArgument::REQUIRED)
            ->addArgument('feed', InputArgument::REQUIRED, "Full path to feed file")
            ->setDescription("Imports a product feed for a specific division.");

        return true;
    }

}
