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
        $_em = $this->getContainer()
            ->get('doctrine')
            ->getManager('orderware');

        $divisionName = $input->getArgument('division');

        // Ensure the division actually exists.
        $division = $_em->getRepository('Orderware:Division')
            ->findOneByDivision($divisionName);

        if (!$division) {
            throw new InvalidArgumentException(sprintf("The division (%s) does not exist.", $divisionName));
        }

        // Ensure the division is enabled.
        if (!$division->isEnabled()) {
            throw new RuntimeException(sprintf("The division (%s) is not enabled.", $divisionName));
        }

        // Ensure the path to the feed file is valid.
        $feedFile = $input->getArgument('feed-file');

        if (!is_file($feedFile)) {
            throw new InvalidArgumentException(sprintf("The feed file (%s) does not exist.", $feedFile));
        }

        // And can be read by Orderware.
        if (!is_readable($feedFile)) {
            throw new InvalidArgumentException(sprintf("The feed file (%s) is not readable.", $feedFile));
        }

        // Get the corresponding XSD to validate the feed against.
        $xsdPath = $this->getContainer()
            ->getKernel()
            ->locateResource('@OrderwareAppBundle/Resources/public/schemas/product_1.0.0.schema.xsd');

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
            ->addArgument('feed-file', InputArgument::REQUIRED, "Full path to feed file")
            ->setDescription("Imports a product feed for a specific division.");

        return true;
    }

}
