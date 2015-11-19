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
            $_em->getConnection()
                ->beginTransaction();

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

            foreach ($json->shipments as $_ship) {
                $shipment = new OrdShip;
                $shipment->setDivision($division)
                    ->setOrder($order)
                    ->setCreatedBy($author)
                    ->setUpdatedBy($author)
                    ->setShipMethod($_ship->shipment_method)
                    ->setFirstName($_ship->first_name)
                    ->setMiddleName($_ship->middle_name)
                    ->setLastName($_ship->last_name)
                    ->setAddress1($_ship->address1)
                    ->setAddress2($_ship->address2)
                    ->setCityName($_ship->city_name)
                    ->setStateName($_ship->state_name)
                    ->setStateCode($_ship->state_code)
                    ->setPostalCode($_ship->postal_code)
                    ->setCountryName($_ship->country_name)
                    ->setCountryCode($_ship->country_code)
                    ->setCompanyName($_ship->company_name)
                    ->setEmailAddress($_ship->email_address)
                    ->setPhoneNumber($_ship->phone_number)
                    ->setNotifyBy($_ship->notify_by)
                    ->setFacilityCode($_ship->facility_code);

                $order->addShipment($shipment);

                foreach ($_ship->lines as $_line) {
                    $itemSku = $_em->getRepository('Orderware:ItemSku')
                        ->findOneBy([
                            'division' => $division,
                            'skucode' => $_line->skucode
                        ]);

                    if ($itemSku) {
                        $item = $itemSku->getItem();

                        $line = new OrdLine;
                        $line->setDivision($division)
                            ->setOrder($order)
                            ->setShipment($shipment)
                            ->setItem($item)
                            ->setSku($itemSku)
                            ->setCreatedBy($author)
                            ->setUpdatedBy($author)
                            ->setStatusId(Status::LINE_OPEN)
                            ->setLineNum($_line->line_num)
                            ->setItemNum($item->getItemNum())
                            ->setItemName($item->getDisplayName())
                            ->setSkucode($itemSku->getSkucode())
                            ->setPickDescription($itemSku->getPickDescription())
                            ->setRetailAmount($_line->retail_amount)
                            ->setDiscountAmount($_line->discount_amount)
                            ->setLocalTaxAmount($_line->local_tax_amount)
                            ->setCountyTaxAmount($_line->county_tax_amount)
                            ->setStateTaxAmount($_line->state_tax_amount)
                            ->setQtyOrdered($_line->quantity);

                        $order->addLine($line);
                    }
                }
            }

            foreach ($json->payments as $_pmt) {
                $payment = new OrdPay;
                $payment->setDivision($division)
                    ->setOrder($order)
                    ->setCreatedBy($author)
                    ->setUpdatedBy($author)
                    ->setPayMethod($_pmt->payment_method)
                    ->setPayAmount($_pmt->amount)
                    ->setTransactionCode($_pmt->transaction_code)
                    ->setCurrency($_pmt->currency);

                $order->addPayment($payment);
            }

            $errors = $this->validator
                ->validate($order);

            if ($errors->count() > 0) {
                throw new InvalidArgumentException(sprintf("Validation error at (%s): %s", $errors[0]->getPropertyPath(), $errors[0]->getMessage()));
            }

            $order->calculate();

            $_em->persist($order);
            $_em->flush();

            $_em->getConnection()
                ->commit();

            $import->setOrdId($order->getOrdId())
                ->setErrorMessage(null);
        } catch (Exception $e) {
            $_em->getConnection()
                ->rollback();

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

        return true;
    }

}
