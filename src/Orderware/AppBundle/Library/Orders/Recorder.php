<?php

namespace Orderware\AppBundle\Library\Orders;

use Orderware\AppBundle\Library\Orders\Loader;

use Doctrine\ORM\EntityManager;

use \InvalidArgumentException;

class Recorder
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var Orderware\AppBundle\Library\Orders\Loader */
    private $loader;

    /** @var array */
    private $order = [];

    /** @var integer */
    private $ordId = 0;

    /** @var string */
    const AUTHOR = 'order_recorder';

    public function __construct(EntityManager $entityManager, Loader $loader)
    {
        $this->entityManager = $entityManager;
        $this->loader = $loader;
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

        // Load the order into memory.
        $this->order = $this->loader
            ->load($this->ordId);

        // Get all ledger records, ord header and each line.
        // Determine if ord header amounts differ than from in ledger.




        // For example: get sum of OSA and OSTA ledgers. Get order shipping amount
        // and order shipping tax amount. Take difference. If difference !== 0,
        // create a new ledger record for each for the difference.





        // Determine if any lines have been canceled and corresponding ledger
        // records also need to be canceled.
        // Save a list of new ledger records.

        // Txn 2. Write new ledger records to the database.

        return true;
    }

}
