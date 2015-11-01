<?php

namespace Orderware\AppBundle\Library\Orders;

use Doctrine\ORM\EntityManager;

use \InvalidArgumentException;

class Loader
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var array */
    private $order = [];

    /** @var integer */
    private $ordId = 0;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function load($division, $orderNum)
    {
        $_conn = $this->entityManager
            ->getConnection();

        // Ensure the order exists first.
        $this->lookupOrder($division, $orderNum);

        // Header
        $sql = "
            SELECT oh.* FROM ord_header oh
            WHERE oh.ord_id = ?
        ";

        $this->order = $_conn->fetchAssoc($sql, [
            $this->ordId
        ]);

        // Shipments
        $sql = "
            SELECT os.* FROM ord_ship os
            WHERE os.ord_id = ?
            ORDER BY os.ord_ship_id ASC
        ";

        $this->order['shipments'] = $_conn->fetchArray($sql, [
            $this->ordId
        ]);

        // Lines
        $sql = "
            SELECT ol.* FROM ord_line ol
            WHERE ol.ord_id = ?
            ORDER BY ol.ord_line_id ASC
        ";

        $this->order['lines'] = $_conn->fetchArray($sql, [
            $this->ordId
        ]);

        // Payments

        // Locks

        // Ledgers

        // Pick Tickets

        // Shipments

        // Invoices

        return $this->order;
    }

    private function lookupOrder($division, $orderNum)
    {
        $this->ordId = $this->entityManager
            ->getConnection()
            ->fetchColumn("SELECT lookup_order(?, ?)", [
                $division, $orderNum
            ]);

        if (0 === $this->ordId) {
            throw new InvalidArgumentException(sprintf("The order number (%s) could not be found.", strtoupper($orderNum)));
        }

        return true;
    }

}
