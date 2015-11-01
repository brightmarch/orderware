<?php

namespace Orderware\AppBundle\Library\Orders;

use Doctrine\ORM\EntityManager;

use \InvalidArgumentException;

class Recorder
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

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
            $ordId
        ]);

        if (!$calculated) {
            throw new InvalidArgumentException(sprintf("The order ID (%d) could not be found.", $this->ordId));
        }

        // Use the Order Loader service to get all order details.

        // Get all ledger records, ord header and each line.
        // Determine if ord header amounts differ than from in ledger.
        // Save a list of new ledger records.

        // Txn 2. Write new ledger records to the database.

        return true;
    }

}
