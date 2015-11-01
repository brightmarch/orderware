<?php

namespace Orderware\AppBundle\Library\Orders;

use Doctrine\ORM\EntityManager;

class Journaler
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var array */
    private $ledgers = [];

    /** @var array */
    private $order = [];

    /** @var array */
    private $lines = [];

    /** @var string */
    const AUTHOR = 'order_journaler';

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function ledger($ordId)
    {
        // Alias this because it's going to be used. A lot.
        $_conn = $this->entityManager
            ->getConnection();

        // Calculate the order. Txn 1.
        $sql = "SELECT calculate_order(?)";

        $calculated = $_conn->fetchColumn($sql, [
            $ordId
        ]);

        if (!$calculated) {
            // Order doesn't exist, bail.
        }

        $sql = "
            SELECT l.ledger_id, l.ord_id,
                l.ord_line_id, l.ledger_code,
                l.amount
            FROM ledger l
            WHERE l.ord_id = ?
            ORDER BY l.ledger_id ASC
        ";

        $sql = "
            SELECT oh.shipping_amount,
                oh.shipping_tax_amount
            FROM ord_header oh
            WHERE oh.ord_id = ?
        ";

        $sql = "
            SELECT ol.qty_ordered, ol.qty_canceled,
                ol.retail_amount, ol.discount_amount,
                ol.tax_amount
            FROM ord_line ol
            WHERE ol.ord_id = ?
            ORDER BY ol.ord_line_id ASC
        ";

        // Get all ledger records, ord header and each line.
        // Determine if ord header amounts differ than from in ledger.
        // Save a list of new ledger records.

        // Txn 2. Write new ledger records to the database.

        return true;
    }

}
