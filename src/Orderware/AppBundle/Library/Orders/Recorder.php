<?php

namespace Orderware\AppBundle\Library\Orders;

use Doctrine\ORM\EntityManager;

use \InvalidArgumentException;

class Recorder
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var array */
    private $order = [];

    /** @var integer */
    private $ordId = 0;

    /** @var string */
    const AUTHOR = 'order_recorder';

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function ledger($ordId)
    {
        // Alias this because it's going to be used. A lot.
        $_conn = $this->entityManager
            ->getConnection();

        $this->ordId = (int)$ordId;

        // Calculate the order. This serves two purposes:
        // 1) It ensures the order actually exists.
        // 2) It ensures all amounts are up to date.
        $sql = "SELECT calculate_order(?)";

        $calculated = $_conn->fetchColumn($sql, [
            $this->ordId
        ]);

        if (!$calculated) {
            throw new InvalidArgumentException(sprintf("The order ID (%d) could not be found.", $this->ordId));
        }

        // Get all ledger records, ord header and each line.
        /*
        $sql = "
            SELECT
                l.ledger_id, l.ord_id, l.ord_line_id,
                l.ledger_code, l.amount, l.is_void
            FROM ledger l
            WHERE l.ord_id = ?
            ORDER BY l.ledger_id ASC
        ";
        */

        // SELECT oh.shipping_amount, oh.shipping_tax_amount FROM ord_header oh WHERE oh.ord_id = ?
        // SELECT ol.qty_available, ol.qty_canceled, ol.retail_amount, ol.tax_amount, ol.discount_amount FROM ord_line ol WHERE ol.ord_id = ? ORDER BY ol.line_num ASC

        // Determine if ord header amounts differ than from in ledger.

        // For example: get sum of OSA and OSTA ledgers. Get order shipping amount
        // and order shipping tax amount. Take difference. If difference !== 0,
        // create a new ledger record for each for the difference.

        // Ord Header Shipping Amount
        // Ord Header Shipping Tax Amount

        // Each Ord Line: Line Amount, Line Tax, Line Discount
        // Cancel any new ledgers.

        // Txn 2. Lock ledger records, Write new ledger records to the database.

        return true;
    }

}
