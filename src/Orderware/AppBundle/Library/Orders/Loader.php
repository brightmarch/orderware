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
            SELECT oh.ord_id AS order_id, oh.order_num, oh.division, oh.created_at,
                oh.updated_at, oh.created_by, oh.updated_by, oh.status_id,
                s.status_code, oh.ordered_at, oh.order_date, oh.source_code,
                oh.order_type, oh.currency, oh.time_zone, oh.line_amount,
                oh.line_tax_amount, oh.shipping_amount, oh.shipping_tax_amount,
                oh.discount_amount, oh.order_amount, oh.salesperson, oh.ip_address,
                oh.customer_notes, oh.store_notes
            FROM ord_header oh
            JOIN status s ON oh.status_id = s.status_id
            WHERE oh.ord_id = ?
        ";

        $this->order = $_conn->fetchAssoc($sql, [
            $this->ordId
        ]);

        // Shipments
        $sql = "
            SELECT os.ord_ship_id AS shipment_id, os.created_at, os.updated_at,
                os.created_by, os.updated_by, os.ship_method, os.first_name,
                os.middle_name, os.last_name, os.full_name, os.address1,
                os.address2, os.city_name, os.state_name, os.state_code,
                os.postal_code, os.country_name, os.country_code, os.company_name,
                os.email_address, os.phone_number, os.notify_by, os.notification_enabled,
                os.facility_code
            FROM ord_ship os
            WHERE os.ord_id = ?
            ORDER BY os.ord_ship_id ASC
        ";

        $this->order['shipments'] = $_conn->fetchAll($sql, [
            $this->ordId
        ]);

        // Lines
        $sql = "
            SELECT ol.* FROM ord_line ol
            WHERE ol.ord_id = ?
            ORDER BY ol.ord_line_id ASC
        ";

        $this->order['lines'] = $_conn->fetchAll($sql, [
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
