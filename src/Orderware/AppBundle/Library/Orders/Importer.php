<?php

namespace Orderware\AppBundle\Library\Orders;

use Orderware\AppBundle\Entity\OrdImport;
use Orderware\AppBundle\Entity\OrdHeader;
use Orderware\AppBundle\Entity\OrdLine;
use Orderware\AppBundle\Entity\OrdShip;
use Orderware\AppBundle\Entity\OrdPay;
use Orderware\AppBundle\Library\Status;
use Orderware\AppBundle\Library\Utils;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\EntityManager;

use \InvalidArgumentException,
    \RuntimeException,
    \Exception;

class Importer
{

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var Symfony\Component\Validator\Validator\ValidatorInterface */
    protected $validator;

    /** @var string */
    const AUTHOR = 'order_importer';

    public function __construct(EntityManager $entityManager, ValidatorInterface $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function import(OrdImport $import)
    {
        // Alias this because it's going to be used. A lot.
        $_em = $this->entityManager;

        // Update the import details to begin with.
        $import->setUpdatedBy(self::AUTHOR)
            ->setStatusId(Status::ORDER_IMPORT_PROCESSING);

        $_em->persist($import);
        $_em->flush();

        // Start your engines.
        $start = microtime(true);

        try {
            // We're going to handle our own transaction here because
            // we want explicit control over locks and when entities
            // are flushed to the database. See the Feeds\AbstractProcessor
            // class for more details on this.
            $_conn = $_em->getConnection();
            $_conn->beginTransaction();

            $json = json_decode($import->getOrderBody());

            // Adjust the order_date to be in the timezone the
            // division is configured under. This makes querying
            // by order date much easier.
            $division = $import->getDivision();
            $timeZone = timezone_open($division->getTimeZone());

            $orderedAt = date_create($json->ordered_at);
            $orderDate = clone $orderedAt;
            $orderDate->setTimezone($timeZone);

            // The salesperson is the author of the entire order.
            $author = $json->salesperson;

            $order = new OrdHeader;
            $order->setDivision($import->getDivision())
                ->setCreatedBy($author)
                ->setUpdatedBy($author)
                ->setStatusId(Status::ORDER_OPEN)
                ->setOrderedAt($orderedAt)
                ->setOrderDate($orderDate)
                ->setSourceCode($json->source_code)
                ->setOrderType($json->order_type)
                ->setOrderNum($json->order_num)
                ->setCurrency($division->getCurrency())
                ->setTimeZone($division->getTimeZone())
                ->setSalesperson($author)
                ->setCustomerNotes($json->customer_notes)
                ->setStoreNotes($json->store_notes)
                ->setIpAddress($json->ip_address)
                ->setShippingAmount($json->shipping_amount)
                ->setShippingLocalTaxAmount($json->shipping_local_tax_amount)
                ->setShippingCountyTaxAmount($json->shipping_county_tax_amount)
                ->setShippingStateTaxAmount($json->shipping_state_tax_amount);

            /*
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
                    $lineNum = $_line->line_num;

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
            */

            $errors = $this->validator
                ->validate($order);

dump($errors);

            $order->calculate();

            $_em->persist($order);
            $_em->flush();

            $_conn->rollback();

            // Only set the ord_header.ord_id value if we
            // know for certain the order was persisted.
            #$import->setOrdId($order->getOrdId());
        } catch (Exception $e) {
            $_conn->rollback();

            $import->setErrorMessage(
                $e->getMessage()
            );
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
