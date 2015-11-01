<?php

namespace Orderware\AppBundle\Library\Orders;

use Orderware\AppBundle\Entity\OrdImport;
#use Orderware\AppBundle\Entity\OrdHeader;
#use Orderware\AppBundle\Entity\OrdLine;
use Orderware\AppBundle\Library\Status;
use Orderware\AppBundle\Library\Utils;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\EntityManager;

use \RuntimeException,
    \Exception;

class Importer
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var Symfony\Component\Validator\Validator\ValidatorInterface */
    private $validator;

    /** @var array */
    private $lineNumbers = [];

    /** @var string */
    const AUTHOR = 'order_importer';

    public function __construct(EntityManager $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function import(OrdImport $import)
    {
        // Alias these because they're going to be used. A lot.
        $_em = $this->entityManager;

        // Update the import details to begin with.
        $import->setUpdatedBy(self::AUTHOR)
            ->setStatusId(Status::ORDER_IMPORT_PROCESSING);

        $_em->persist($import);
        $_em->flush();

        // Start your engines.
        $start = microtime(true);

        try {
            $json = json_decode($import->getOrderBody());

            // We're going to handle our own transaction here because
            // we want explicit control over locks and when entities
            // are flushed to the database. See the Feeds\AbstractProcessor
            // class for more details on this.
            $_conn = $_em->getConnection();
            $_conn->beginTransaction();

            // The order number is always uppercased.
            $orderNum = strtoupper($json->order_num);

            // The order_header.ordered_at value should always be in UTC.
            $orderedAt = date_create($json->ordered_at);

            // However, the order_header.order_date should
            // be in the divisions's timezone so no timezone
            // adjustments need to be made when querying for it.
            $division = $import->getDivision();

            $timeZone = timezone_open($division->getTimeZone());
            $orderDate = clone $orderedAt;
            $orderDate->setTimezone($timeZone);

            $orderedAt = Utils::dbDate($orderedAt);
            $orderDate = Utils::dbDate($orderDate);

            // Alias the actual division name.
            $currency = $division->getCurrency();
            $division = $division->getDivision();

            // Ensure the order number is unique.
            $sql = "SELECT lookup_order(?, ?)";

            $ordId = $_conn->fetchColumn($sql, [
                $division, $orderNum
            ]);

            if ($ordId > 0) {
                throw new RuntimeException(sprintf("The order number (%s) already exists.", $orderNum));
            }

            // Generate a new ord_id to use throughout the transaction.
            $ordId = $_conn->fetchColumn("
                SELECT nextval('ord_header_ord_id_seq')
            ");

            // Ensure the order number is alpha-numeric.
            $match = preg_match('/^[A-Z0-9]+$/', $orderNum);

            if (0 === $match) {
                throw new InvalidArgumentException(sprintf("The order number (%s) must be alpha-numeric.", $orderNum));
            }

            // The salesperson is the author of the entire order.
            $author = $json->salesperson;

            $_conn->insert('ord_header', [
                'ord_id' => $ordId,
                'created_by' => $author,
                'updated_by' => $author,
                'division' => $division,
                'status_id' => Status::ORDER_OPEN,
                'ordered_at' => $orderedAt,
                'order_date' => $orderDate,
                'source_code' => $json->source_code,
                'order_type' => $json->order_type,
                'order_num' => $orderNum,
                'currency' => $currency,
                'time_zone' => $timeZone->getName(),
                'salesperson' => $author,
                'customer_notes' => $json->customer_notes,
                'store_notes' => $json->store_notes,
                'ip_address' => $json->ip_address,
                'shipping_amount' => $json->shipping_amount,
                'shipping_local_tax_amount' => $json->shipping_local_tax_amount,
                'shipping_county_tax_amount' => $json->shipping_county_tax_amount,
                'shipping_state_tax_amount' => $json->shipping_state_tax_amount
            ]);

            foreach ($json->shipments as $_ship) {
                $ordShipId = $_conn->fetchColumn("
                    SELECT nextval('ord_ship_ord_ship_id_seq')
                ");

                $_conn->insert('ord_ship', [
                    'ord_ship_id' => $ordShipId,
                    'created_by' => $author,
                    'updated_by' => $author,
                    'division' => $division,
                    'ord_id' => $ordId,
                    'ship_method' => $_ship->shipment_method,
                    'first_name' => $_ship->first_name,
                    'middle_name' => $_ship->middle_name,
                    'last_name' => $_ship->last_name,
                    'address1' => $_ship->address1,
                    'address2' => $_ship->address2,
                    'city_name' => $_ship->city_name,
                    'state_name' => $_ship->state_name,
                    'state_code' => $_ship->state_code,
                    'postal_code' => $_ship->postal_code,
                    'country_name' => $_ship->country_name,
                    'country_code' => $_ship->country_code,
                    'email_address' => $_ship->email_address,
                    'phone_number' => $_ship->phone_number,
                    'notify_by' => strtolower($_ship->notify_by),
                    'facility_code' => strtoupper($_ship->facility_code)
                ]);

                foreach ($_ship->lines as $_line) {
                    $lineNum = $_line->line_number;

                    // Ensure the line number is unique.
                    if (isset($this->lineNumbers[$lineNum])) {
                        throw new RuntimeException(sprintf("The line number (%s) is already used in this order.", $lineNum));
                    }

                    // Memoize the line numbers to avoid a
                    // a query for each line being inserted.
                    $this->lineNumbers[$lineNum] = true;

                    // Attempt to find the matching SKU.
                    $sql = "
                        SELECT i.item_id, isk.sku_id, i.item_num,
                            i.display_name, i.is_virtual,
                            isk.skucode, isk.pick_description
                        FROM item i
                        JOIN item_sku isk ON i.item_id = isk.item_id
                        WHERE isk.division = ?
                            AND isk.skucode = ?
                    ";

                    $sku = $_conn->fetchAssoc($sql, [
                        $division, $_line->skucode
                    ]);

                    if (!$sku) {
                        throw new RuntimeException(sprintf("The SKU (%s) could not be found.", $_line->skucode));
                    }

                    $_conn->insert('ord_line', [
                        'created_by' => $author,
                        'updated_by' => $author,
                        'division' => $division,
                        'ord_id' => $ordId,
                        'ord_ship_id' => $ordShipId,
                        'item_id' => $sku['item_id'],
                        'sku_id' => $sku['sku_id'],
                        'status_id' => Status::LINE_OPEN,
                        'line_num' => $lineNum,
                        'item_num' => $sku['item_num'],
                        'item_name' => $sku['display_name'],
                        'skucode' => $_line->skucode,
                        'pick_description' => $sku['pick_description'],
                        'retail_amount' => $_line->retail_amount,
                        'discount_amount' => $_line->discount_amount,
                        'local_tax_amount' => $_line->local_tax_amount,
                        'county_tax_amount' => $_line->county_tax_amount,
                        'state_tax_amount' => $_line->state_tax_amount,
                        'qty_ordered' => $_line->quantity
                    ]);
                }
            }

            foreach ($json->payments as $_pmt) {
                $_conn->insert('ord_pay', [
                    'created_by' => $author,
                    'updated_by' => $author,
                    'division' => $division,
                    'ord_id' => $ordId,
                    'pay_method' => $_pmt->payment_method,
                    'pay_amount' => $_pmt->amount,
                    'transaction_code' => $_pmt->transaction_code,
                    'currency' => $_pmt->currency
                ]);
            }

            $_conn->commit();

            // Only set the ord_header.ord_id value if we
            // know for certain the order was persisted.
            $import->setOrdId($ordId);
        } catch (Exception $e) {
            $_conn->rollback();

            $import->setErrorMessage($e->getMessage());
        }

        // Determine the runtime in milliseconds.
        $runTime = round((microtime(true) - $start) * 1000, 0);

        // And finally, wrap everything up so the main
        // details about this import can be referenced.
        $import->setStatusId(Status::ORDER_IMPORT_PROCESSED)
            ->setRunTime((int)$runTime)
            ->setMemoryUsage(memory_get_peak_usage());

        $_em->persist($import);
        $_em->flush();

        return $import;
    }

}
