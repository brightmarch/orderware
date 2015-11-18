<?php

namespace Orderware\AppBundle\Entity;

use Orderware\AppBundle\Entity\OrdLine;
use Orderware\AppBundle\Entity\OrdLock;
use Orderware\AppBundle\Library\Status;

/**
 * OrdHeader
 */
class OrdHeader
{

    /**
     * @var integer
     */
    private $ordId;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var string
     */
    private $createdBy;

    /**
     * @var string
     */
    private $updatedBy;

    /**
     * @var integer
     */
    private $statusId = Status::ORDER_OPEN;

    /**
     * @var \DateTime
     */
    private $orderedAt;

    /**
     * @var \DateTime
     */
    private $orderDate;

    /**
     * @var string
     */
    private $sourceCode;

    /**
     * @var string
     */
    private $orderType;

    /**
     * @var string
     */
    private $orderNum;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $timeZone;

    /**
     * @var integer
     */
    private $lineAmount = 0;

    /**
     * @var integer
     */
    private $lineTaxAmount = 0;

    /**
     * @var integer
     */
    private $lineLocalTaxAmount = 0;

    /**
     * @var integer
     */
    private $lineCountyTaxAmount = 0;

    /**
     * @var integer
     */
    private $lineStateTaxAmount = 0;

    /**
     * @var integer
     */
    private $shippingAmount = 0;

    /**
     * @var integer
     */
    private $shippingTaxAmount = 0;

    /**
     * @var integer
     */
    private $shippingLocalTaxAmount = 0;

    /**
     * @var integer
     */
    private $shippingCountyTaxAmount = 0;

    /**
     * @var integer
     */
    private $shippingStateTaxAmount = 0;

    /**
     * @var integer
     */
    private $discountAmount = 0;

    /**
     * @var integer
     */
    private $orderAmount = 0;

    /**
     * @var boolean
     */
    private $isVirtual = false;

    /**
     * @var string
     */
    private $salesperson;

    /**
     * @var string
     */
    private $ipAddress;

    /**
     * @var string
     */
    private $customerNotes;

    /**
     * @var string
     */
    private $storeNotes;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $ledgers;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lines;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $locks;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $payments;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $shipments;

    /**
     * @var \Orderware\AppBundle\Entity\Division
     */
    private $division;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ledgers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->lines = new \Doctrine\Common\Collections\ArrayCollection();
        $this->locks = new \Doctrine\Common\Collections\ArrayCollection();
        $this->payments = new \Doctrine\Common\Collections\ArrayCollection();
        $this->shipments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get ordId
     *
     * @return integer
     */
    public function getOrdId()
    {
        return $this->ordId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return OrdHeader
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return OrdHeader
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Set createdBy
     *
     * @param string $createdBy
     *
     * @return OrdHeader
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * Get createdBy
     *
     * @return string
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * Set updatedBy
     *
     * @param string $updatedBy
     *
     * @return OrdHeader
     */
    public function setUpdatedBy($updatedBy)
    {
        $this->updatedBy = $updatedBy;

        return $this;
    }

    /**
     * Get updatedBy
     *
     * @return string
     */
    public function getUpdatedBy()
    {
        return $this->updatedBy;
    }

    /**
     * Set statusId
     *
     * @param integer $statusId
     *
     * @return OrdHeader
     */
    public function setStatusId($statusId)
    {
        $this->statusId = $statusId;

        return $this;
    }

    /**
     * Get statusId
     *
     * @return integer
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * Set orderedAt
     *
     * @param \DateTime $orderedAt
     *
     * @return OrdHeader
     */
    public function setOrderedAt($orderedAt)
    {
        $this->orderedAt = $orderedAt;

        return $this;
    }

    /**
     * Get orderedAt
     *
     * @return \DateTime
     */
    public function getOrderedAt()
    {
        return $this->orderedAt;
    }

    /**
     * Set orderDate
     *
     * @param \DateTime $orderDate
     *
     * @return OrdHeader
     */
    public function setOrderDate($orderDate)
    {
        $this->orderDate = $orderDate;

        return $this;
    }

    /**
     * Get orderDate
     *
     * @return \DateTime
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * Set sourceCode
     *
     * @param string $sourceCode
     *
     * @return OrdHeader
     */
    public function setSourceCode($sourceCode)
    {
        $this->sourceCode = $sourceCode;

        return $this;
    }

    /**
     * Get sourceCode
     *
     * @return string
     */
    public function getSourceCode()
    {
        return $this->sourceCode;
    }

    /**
     * Set orderType
     *
     * @param string $orderType
     *
     * @return OrdHeader
     */
    public function setOrderType($orderType)
    {
        $this->orderType = $orderType;

        return $this;
    }

    /**
     * Get orderType
     *
     * @return string
     */
    public function getOrderType()
    {
        return $this->orderType;
    }

    /**
     * Set orderNum
     *
     * @param string $orderNum
     *
     * @return OrdHeader
     */
    public function setOrderNum($orderNum)
    {
        $this->orderNum = strtoupper($orderNum);

        return $this;
    }

    /**
     * Get orderNum
     *
     * @return string
     */
    public function getOrderNum()
    {
        return $this->orderNum;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return OrdHeader
     */
    public function setCurrency($currency)
    {
        $this->currency = strtoupper($currency);

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set timeZone
     *
     * @param string $timeZone
     *
     * @return OrdHeader
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;

        return $this;
    }

    /**
     * Get timeZone
     *
     * @return string
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }

    /**
     * Set lineAmount
     *
     * @param integer $lineAmount
     *
     * @return OrdHeader
     */
    public function setLineAmount($lineAmount)
    {
        $this->lineAmount = (int)$lineAmount;

        return $this;
    }

    /**
     * Get lineAmount
     *
     * @return integer
     */
    public function getLineAmount()
    {
        return $this->lineAmount;
    }

    /**
     * Set lineTaxAmount
     *
     * @param integer $lineTaxAmount
     *
     * @return OrdHeader
     */
    public function setLineTaxAmount($lineTaxAmount)
    {
        $this->lineTaxAmount = (int)$lineTaxAmount;

        return $this;
    }

    /**
     * Get lineTaxAmount
     *
     * @return integer
     */
    public function getLineTaxAmount()
    {
        return $this->lineTaxAmount;
    }

    /**
     * Set lineLocalTaxAmount
     *
     * @param integer $lineLocalTaxAmount
     *
     * @return OrdHeader
     */
    public function setLineLocalTaxAmount($lineLocalTaxAmount)
    {
        $this->lineLocalTaxAmount = (int)$lineLocalTaxAmount;

        return $this;
    }

    /**
     * Get lineLocalTaxAmount
     *
     * @return integer
     */
    public function getLineLocalTaxAmount()
    {
        return $this->lineLocalTaxAmount;
    }

    /**
     * Set lineCountyTaxAmount
     *
     * @param integer $lineCountyTaxAmount
     *
     * @return OrdHeader
     */
    public function setLineCountyTaxAmount($lineCountyTaxAmount)
    {
        $this->lineCountyTaxAmount = (int)$lineCountyTaxAmount;

        return $this;
    }

    /**
     * Get lineCountyTaxAmount
     *
     * @return integer
     */
    public function getLineCountyTaxAmount()
    {
        return $this->lineCountyTaxAmount;
    }

    /**
     * Set lineStateTaxAmount
     *
     * @param integer $lineStateTaxAmount
     *
     * @return OrdHeader
     */
    public function setLineStateTaxAmount($lineStateTaxAmount)
    {
        $this->lineStateTaxAmount = (int)$lineStateTaxAmount;

        return $this;
    }

    /**
     * Get lineStateTaxAmount
     *
     * @return integer
     */
    public function getLineStateTaxAmount()
    {
        return $this->lineStateTaxAmount;
    }

    /**
     * Set shippingAmount
     *
     * @param integer $shippingAmount
     *
     * @return OrdHeader
     */
    public function setShippingAmount($shippingAmount)
    {
        $this->shippingAmount = (int)$shippingAmount;

        return $this;
    }

    /**
     * Get shippingAmount
     *
     * @return integer
     */
    public function getShippingAmount()
    {
        return $this->shippingAmount;
    }

    /**
     * Set shippingTaxAmount
     *
     * @param integer $shippingTaxAmount
     *
     * @return OrdHeader
     */
    public function setShippingTaxAmount($shippingTaxAmount)
    {
        $this->shippingTaxAmount = (int)$shippingTaxAmount;

        return $this;
    }

    /**
     * Get shippingTaxAmount
     *
     * @return integer
     */
    public function getShippingTaxAmount()
    {
        return $this->shippingTaxAmount;
    }

    /**
     * Set shippingLocalTaxAmount
     *
     * @param integer $shippingLocalTaxAmount
     *
     * @return OrdHeader
     */
    public function setShippingLocalTaxAmount($shippingLocalTaxAmount)
    {
        $this->shippingLocalTaxAmount = (int)$shippingLocalTaxAmount;

        return $this;
    }

    /**
     * Get shippingLocalTaxAmount
     *
     * @return integer
     */
    public function getShippingLocalTaxAmount()
    {
        return $this->shippingLocalTaxAmount;
    }

    /**
     * Set shippingCountyTaxAmount
     *
     * @param integer $shippingCountyTaxAmount
     *
     * @return OrdHeader
     */
    public function setShippingCountyTaxAmount($shippingCountyTaxAmount)
    {
        $this->shippingCountyTaxAmount = (int)$shippingCountyTaxAmount;

        return $this;
    }

    /**
     * Get shippingCountyTaxAmount
     *
     * @return integer
     */
    public function getShippingCountyTaxAmount()
    {
        return $this->shippingCountyTaxAmount;
    }

    /**
     * Set shippingStateTaxAmount
     *
     * @param integer $shippingStateTaxAmount
     *
     * @return OrdHeader
     */
    public function setShippingStateTaxAmount($shippingStateTaxAmount)
    {
        $this->shippingStateTaxAmount = (int)$shippingStateTaxAmount;

        return $this;
    }

    /**
     * Get shippingStateTaxAmount
     *
     * @return integer
     */
    public function getShippingStateTaxAmount()
    {
        return $this->shippingStateTaxAmount;
    }

    /**
     * Set discountAmount
     *
     * @param integer $discountAmount
     *
     * @return OrdHeader
     */
    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = (int)$discountAmount;

        return $this;
    }

    /**
     * Get discountAmount
     *
     * @return integer
     */
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    /**
     * Set orderAmount
     *
     * @param integer $orderAmount
     *
     * @return OrdHeader
     */
    public function setOrderAmount($orderAmount)
    {
        $this->orderAmount = (int)$orderAmount;

        return $this;
    }

    /**
     * Get orderAmount
     *
     * @return integer
     */
    public function getOrderAmount()
    {
        return $this->orderAmount;
    }

    /**
     * Set isVirtual
     *
     * @param boolean $isVirtual
     *
     * @return OrdHeader
     */
    public function setIsVirtual($isVirtual)
    {
        $this->isVirtual = (float)$isVirtual;

        return $this;
    }

    /**
     * Get isVirtual
     *
     * @return boolean
     */
    public function getIsVirtual()
    {
        return $this->isVirtual;
    }

    /**
     * Set salesperson
     *
     * @param string $salesperson
     *
     * @return OrdHeader
     */
    public function setSalesperson($salesperson)
    {
        $this->salesperson = $salesperson;

        return $this;
    }

    /**
     * Get salesperson
     *
     * @return string
     */
    public function getSalesperson()
    {
        return $this->salesperson;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return OrdHeader
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set customerNotes
     *
     * @param string $customerNotes
     *
     * @return OrdHeader
     */
    public function setCustomerNotes($customerNotes)
    {
        $this->customerNotes = $customerNotes;

        return $this;
    }

    /**
     * Get customerNotes
     *
     * @return string
     */
    public function getCustomerNotes()
    {
        return $this->customerNotes;
    }

    /**
     * Set storeNotes
     *
     * @param string $storeNotes
     *
     * @return OrdHeader
     */
    public function setStoreNotes($storeNotes)
    {
        $this->storeNotes = $storeNotes;

        return $this;
    }

    /**
     * Get storeNotes
     *
     * @return string
     */
    public function getStoreNotes()
    {
        return $this->storeNotes;
    }

    /**
     * Add ledger
     *
     * @param \Orderware\AppBundle\Entity\Ledger $ledger
     *
     * @return OrdHeader
     */
    public function addLedger(\Orderware\AppBundle\Entity\Ledger $ledger)
    {
        $this->ledgers[] = $ledger;

        return $this;
    }

    /**
     * Remove ledger
     *
     * @param \Orderware\AppBundle\Entity\Ledger $ledger
     */
    public function removeLedger(\Orderware\AppBundle\Entity\Ledger $ledger)
    {
        $this->ledgers->removeElement($ledger);
    }

    /**
     * Get ledgers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLedgers()
    {
        return $this->ledgers;
    }

    /**
     * Add line
     *
     * @param \Orderware\AppBundle\Entity\OrdLine $line
     *
     * @return OrdHeader
     */
    public function addLine(\Orderware\AppBundle\Entity\OrdLine $line)
    {
        $this->lines[] = $line;

        return $this;
    }

    /**
     * Remove line
     *
     * @param \Orderware\AppBundle\Entity\OrdLine $line
     */
    public function removeLine(\Orderware\AppBundle\Entity\OrdLine $line)
    {
        $this->lines->removeElement($line);
    }

    /**
     * Get lines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Add lock
     *
     * @param \Orderware\AppBundle\Entity\OrdLock $lock
     *
     * @return OrdHeader
     */
    public function addLock(\Orderware\AppBundle\Entity\OrdLock $lock)
    {
        $this->locks[] = $lock;

        return $this;
    }

    /**
     * Remove lock
     *
     * @param \Orderware\AppBundle\Entity\OrdLock $lock
     */
    public function removeLock(\Orderware\AppBundle\Entity\OrdLock $lock)
    {
        $this->locks->removeElement($lock);
    }

    /**
     * Get locks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLocks()
    {
        return $this->locks;
    }

    /**
     * Add payment
     *
     * @param \Orderware\AppBundle\Entity\OrdPay $payment
     *
     * @return OrdHeader
     */
    public function addPayment(\Orderware\AppBundle\Entity\OrdPay $payment)
    {
        $this->payments[] = $payment;

        return $this;
    }

    /**
     * Remove payment
     *
     * @param \Orderware\AppBundle\Entity\OrdPay $payment
     */
    public function removePayment(\Orderware\AppBundle\Entity\OrdPay $payment)
    {
        $this->payments->removeElement($payment);
    }

    /**
     * Get payments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPayments()
    {
        return $this->payments;
    }

    /**
     * Add shipment
     *
     * @param \Orderware\AppBundle\Entity\OrdShip $shipment
     *
     * @return OrdHeader
     */
    public function addShipment(\Orderware\AppBundle\Entity\OrdShip $shipment)
    {
        $this->shipments[] = $shipment;

        return $this;
    }

    /**
     * Remove shipment
     *
     * @param \Orderware\AppBundle\Entity\OrdShip $shipment
     */
    public function removeShipment(\Orderware\AppBundle\Entity\OrdShip $shipment)
    {
        $this->shipments->removeElement($shipment);
    }

    /**
     * Get shipments
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getShipments()
    {
        return $this->shipments;
    }

    /**
     * Set division
     *
     * @param \Orderware\AppBundle\Entity\Division $division
     *
     * @return OrdHeader
     */
    public function setDivision(\Orderware\AppBundle\Entity\Division $division = null)
    {
        $this->division = $division;

        return $this;
    }

    /**
     * Get division
     *
     * @return \Orderware\AppBundle\Entity\Division
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * @ORM\PrePersist
     */
    public function onCreate()
    {
        $this->setCreatedAt(date_create())
            ->setUpdatedAt(date_create());
    }

    /**
     * @ORM\PreUpdate
     */
    public function onUpdate()
    {
        $this->setUpdatedAt(date_create());
    }

    /**
     * Get activeLocks
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getActiveLocks()
    {
        $filter = function(OrdLock $lock) {
            return $lock->isActive();
        };

        return $this->getLocks()
            ->filter($filter);
    }

    /**
     * Has uniqueLineNumbers
     *
     * @return boolean
     */
    public function hasUniqueLineNumbers()
    {
        $lineNumbers = array_map(function(OrdLine $line) {
            return $line->getLineNum();
        }, $this->getLines()->toArray());

        return (
            count($lineNumbers) === count(array_unique($lineNumbers))
        );
    }

    /**
     * Is locked
     *
     * @return boolean
     */
    public function isLocked()
    {
        return ($this->getActiveLocks()->count() > 0);
    }

    /**
     * Calculate
     *
     * @return OrdHeader
     */
    public function calculate()
    {
        // Line tax, total, and discount amounts.
        $lineAmount = 0;
        $discountAmount = 0;
        $orderAmount = 0;
        $lineTaxAmount = 0;
        $lineLocalTaxAmount = 0;
        $lineCountyTaxAmount = 0;
        $lineStateTaxAmount = 0;

        foreach ($this->getLines() as $line) {
            // Perform the latest calculations on the line to
            // ensure all values are current.
            $line->calculate();

            $avail = $line->getQtyAvailable();

            // Line amounts.
            $lineAmount += ($line->getRetailAmount() * $avail);
            $discountAmount += ($line->getDiscountAmount() * $avail);

            // Line tax amounts.
            $lineTaxAmount += ($line->getTaxAmount() * $avail);
            $lineLocalTaxAmount += ($line->getLocalTaxAmount() * $avail);
            $lineCountyTaxAmount += ($line->getCountyTaxAmount() * $avail);
            $lineStateTaxAmount += ($line->getStateTaxAmount() * $avail);
        }

        // Set calculated amounts.
        $this->setLineAmount($lineAmount)
            ->setLineTaxAmount($lineTaxAmount)
            ->setLineLocalTaxAmount($lineLocalTaxAmount)
            ->setLineCountyTaxAmount($lineCountyTaxAmount)
            ->setLineStateTaxAmount($lineStateTaxAmount)
            ->setDiscountAmount($discountAmount);

        // Shipping tax amount.
        $this->setShippingTaxAmount(
            $this->getShippingLocalTaxAmount() +
            $this->getShippingCountyTaxAmount() +
            $this->getShippingStateTaxAmount()
        );

        // Order total amount.
        $this->setOrderAmount(
            $lineAmount -
            $discountAmount +
            $lineTaxAmount +
            $this->getShippingAmount() +
            $this->getShippingTaxAmount()
        );

        return $this;
    }

}
