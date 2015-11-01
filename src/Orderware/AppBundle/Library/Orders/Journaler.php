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

        // Ensure the order actually exists.

        // Calculate the order. Txn 1.
        #$_conn->beginTransaction();
        $sql = "SELECT calculate_order(?, ?)";

        $calculated = $_conn->fetchColumn($sql, [$ordId]);
        #$_conn->commit();

        // Get all ledger records, ord header and each line.
        // Determine if ord header amounts differ than from in ledger.
        // Save a list of new ledger records.

        // Txn 2. Write new ledger records to the database.

        return true;
    }

}
