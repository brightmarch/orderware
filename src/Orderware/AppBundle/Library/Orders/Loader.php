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
        $this->ordId = $_conn->fetchColumn("SELECT lookup_order(?, ?)", [
            $division, $orderNum
        ]);

        if (0 === $this->ordId) {
            throw new InvalidArgumentException(sprintf("The order number (%s) could not be found.", strtoupper($orderNum)));
        }

        $sql = "
            SELECT oh.* FROM ord_header oh
            WHERE oh.ord_id = ?
        ";

        $this->order = $_conn->fetchAssoc($sql, [
            $this->ordId
        ]);

        return $this->order;
    }

}
