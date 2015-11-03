<?php

namespace Orderware\AppBundle\Entity;

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
    private $statusId;

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
    private $lineAmount;

    /**
     * @var integer
     */
    private $lineTaxAmount;

    /**
     * @var integer
     */
    private $lineLocalTaxAmount;

    /**
     * @var integer
     */
    private $lineCountyTaxAmount;

    /**
     * @var integer
     */
    private $lineStateTaxAmount;

    /**
     * @var integer
     */
    private $shippingAmount;

    /**
     * @var integer
     */
    private $shippingTaxAmount;

    /**
     * @var integer
     */
    private $shippingLocalTaxAmount;

    /**
     * @var integer
     */
    private $shippingCountyTaxAmount;

    /**
     * @var integer
     */
    private $shippingStateTaxAmount;

    /**
     * @var integer
     */
    private $discountAmount;

    /**
     * @var integer
     */
    private $orderAmount;

    /**
     * @var boolean
     */
    private $isVirtual;

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
        $this->orderNum = $orderNum;

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
        $this->currency = $currency;

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
        $this->lineAmount = $lineAmount;

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
        $this->lineTaxAmount = $lineTaxAmount;

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
        $this->lineLocalTaxAmount = $lineLocalTaxAmount;

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
        $this->lineCountyTaxAmount = $lineCountyTaxAmount;

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
        $this->lineStateTaxAmount = $lineStateTaxAmount;

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
        $this->shippingAmount = $shippingAmount;

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
        $this->shippingTaxAmount = $shippingTaxAmount;

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
        $this->shippingLocalTaxAmount = $shippingLocalTaxAmount;

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
        $this->shippingCountyTaxAmount = $shippingCountyTaxAmount;

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
        $this->shippingStateTaxAmount = $shippingStateTaxAmount;

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
        $this->discountAmount = $discountAmount;

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
        $this->orderAmount = $orderAmount;

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
        $this->isVirtual = $isVirtual;

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
     * @param \Orderware\AppBundle\Entity\OrdShipment $shipment
     *
     * @return OrdHeader
     */
    public function addShipment(\Orderware\AppBundle\Entity\OrdShipment $shipment)
    {
        $this->shipments[] = $shipment;

        return $this;
    }

    /**
     * Remove shipment
     *
     * @param \Orderware\AppBundle\Entity\OrdShipment $shipment
     */
    public function removeShipment(\Orderware\AppBundle\Entity\OrdShipment $shipment)
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
        // Add your code here
    }

    /**
     * @ORM\PreUpdate
     */
    public function onUpdate()
    {
        // Add your code here
    }
}

