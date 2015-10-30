<?php

namespace Orderware\AppBundle\Command;

use Orderware\AppBundle\Entity\OrdImport;
use Orderware\AppBundle\Library\Status;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use \InvalidArgumentException;

class ImportOrderCommand extends ContainerAwareCommand
{

    /** @const string */
    const AUTHOR = 'import_author';

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $order = $input->getArgument('order');

        $_em = $this->getContainer()
            ->get('doctrine')
            ->getManager();

        if (is_numeric($order)) {
            $import = $_em->getRepository('Orderware:OrdImport')
                ->findOneByImportId((int)$order);

            if (!$import) {
                throw new InvalidArgumentException(sprintf("The order import (%s) could not be found.", $order));
            }
        } else {
            // Ensure the order file exists.
            if (!is_readable($order)) {
                throw new InvalidArgumentException(sprintf("The order file (%s) is not readable.", $order));
            }

            // And validate it against the schema.
            $orderJson = file_get_contents($order);

            $this->getContainer()
                ->get('orderware.json_validator')
                ->validate('order', $orderJson);

            // Parse it to grab the division.
            $order = json_decode($orderJson);

            // And ensure the division exists.
            $division = $_em->getRepository('Orderware:Division')
                ->findOneByDivision($order->division);

            if (!$division) {
                throw new InvalidArgumentException(sprintf("The division (%s) does not exist.", $order->division));
            }

            $import = new OrdImport;
            $import->setCreatedBy(self::AUTHOR)
                ->setUpdatedBy(self::AUTHOR)
                ->setDivision($division)
                ->setStatusId(Status::ORDER_IMPORT_ENQUEUED)
                ->setOrderNum($order->order_num)
                ->setOrderBody($orderJson);

            $_em->persist($import);
            $_em->flush();
        }

        // And actually import the order.
        $this->getContainer()
            ->get('orderware.order_importer')
            ->import($import);

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
