<?php

namespace Orderware\AppBundle\Entity;

/**
 * OrdLine
 */
class OrdLine
{
    /**
     * @var integer
     */
    private $ordLineId;

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
     * @var string
     */
    private $lineNum;

    /**
     * @var string
     */
    private $itemNum;

    /**
     * @var string
     */
    private $itemName;

    /**
     * @var string
     */
    private $skucode;

    /**
     * @var string
     */
    private $pickDescription;

    /**
     * @var integer
     */
    private $retailAmount;

    /**
     * @var integer
     */
    private $discountAmount;

    /**
     * @var integer
     */
    private $taxAmount;

    /**
     * @var integer
     */
    private $localTaxAmount;

    /**
     * @var integer
     */
    private $countyTaxAmount;

    /**
     * @var integer
     */
    private $stateTaxAmount;

    /**
     * @var integer
     */
    private $qtyOrdered;

    /**
     * @var integer
     */
    private $qtyAvailable;

    /**
     * @var integer
     */
    private $qtyCanceled;

    /**
     * @var integer
     */
    private $qtyBackordered;

    /**
     * @var integer
     */
    private $qtyAllocated;

    /**
     * @var integer
     */
    private $qtyReserved;

    /**
     * @var integer
     */
    private $qtyPicked;

    /**
     * @var integer
     */
    private $qtyShipped;

    /**
     * @var integer
     */
    private $qtyReturned;

    /**
     * @var \Orderware\AppBundle\Entity\Division
     */
    private $division;

    /**
     * @var \Orderware\AppBundle\Entity\OrdHeader
     */
    private $order;

    /**
     * @var \Orderware\AppBundle\Entity\OrdShip
     */
    private $shipment;

    /**
     * @var \Orderware\AppBundle\Entity\Item
     */
    private $item;

    /**
     * @var \Orderware\AppBundle\Entity\ItemSku
     */
    private $sku;

    /**
     * @var \Orderware\AppBundle\Entity\Facility
     */
    private $facility;


    /**
     * Get ordLineId
     *
     * @return integer
     */
    public function getOrdLineId()
    {
        return $this->ordLineId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return OrdLine
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
     * @return OrdLine
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
     * @return OrdLine
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
     * @return OrdLine
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
     * @return OrdLine
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
     * Set lineNum
     *
     * @param string $lineNum
     *
     * @return OrdLine
     */
    public function setLineNum($lineNum)
    {
        $this->lineNum = $lineNum;

        return $this;
    }

    /**
     * Get lineNum
     *
     * @return string
     */
    public function getLineNum()
    {
        return $this->lineNum;
    }

    /**
     * Set itemNum
     *
     * @param string $itemNum
     *
     * @return OrdLine
     */
    public function setItemNum($itemNum)
    {
        $this->itemNum = $itemNum;

        return $this;
    }

    /**
     * Get itemNum
     *
     * @return string
     */
    public function getItemNum()
    {
        return $this->itemNum;
    }

    /**
     * Set itemName
     *
     * @param string $itemName
     *
     * @return OrdLine
     */
    public function setItemName($itemName)
    {
        $this->itemName = $itemName;

        return $this;
    }

    /**
     * Get itemName
     *
     * @return string
     */
    public function getItemName()
    {
        return $this->itemName;
    }

    /**
     * Set skucode
     *
     * @param string $skucode
     *
     * @return OrdLine
     */
    public function setSkucode($skucode)
    {
        $this->skucode = $skucode;

        return $this;
    }

    /**
     * Get skucode
     *
     * @return string
     */
    public function getSkucode()
    {
        return $this->skucode;
    }

    /**
     * Set pickDescription
     *
     * @param string $pickDescription
     *
     * @return OrdLine
     */
    public function setPickDescription($pickDescription)
    {
        $this->pickDescription = $pickDescription;

        return $this;
    }

    /**
     * Get pickDescription
     *
     * @return string
     */
    public function getPickDescription()
    {
        return $this->pickDescription;
    }

    /**
     * Set retailAmount
     *
     * @param integer $retailAmount
     *
     * @return OrdLine
     */
    public function setRetailAmount($retailAmount)
    {
        $this->retailAmount = $retailAmount;

        return $this;
    }

    /**
     * Get retailAmount
     *
     * @return integer
     */
    public function getRetailAmount()
    {
        return $this->retailAmount;
    }

    /**
     * Set discountAmount
     *
     * @param integer $discountAmount
     *
     * @return OrdLine
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
     * Set taxAmount
     *
     * @param integer $taxAmount
     *
     * @return OrdLine
     */
    public function setTaxAmount($taxAmount)
    {
        $this->taxAmount = $taxAmount;

        return $this;
    }

    /**
     * Get taxAmount
     *
     * @return integer
     */
    public function getTaxAmount()
    {
        return $this->taxAmount;
    }

    /**
     * Set localTaxAmount
     *
     * @param integer $localTaxAmount
     *
     * @return OrdLine
     */
    public function setLocalTaxAmount($localTaxAmount)
    {
        $this->localTaxAmount = $localTaxAmount;

        return $this;
    }

    /**
     * Get localTaxAmount
     *
     * @return integer
     */
    public function getLocalTaxAmount()
    {
        return $this->localTaxAmount;
    }

    /**
     * Set countyTaxAmount
     *
     * @param integer $countyTaxAmount
     *
     * @return OrdLine
     */
    public function setCountyTaxAmount($countyTaxAmount)
    {
        $this->countyTaxAmount = $countyTaxAmount;

        return $this;
    }

    /**
     * Get countyTaxAmount
     *
     * @return integer
     */
    public function getCountyTaxAmount()
    {
        return $this->countyTaxAmount;
    }

    /**
     * Set stateTaxAmount
     *
     * @param integer $stateTaxAmount
     *
     * @return OrdLine
     */
    public function setStateTaxAmount($stateTaxAmount)
    {
        $this->stateTaxAmount = $stateTaxAmount;

        return $this;
    }

    /**
     * Get stateTaxAmount
     *
     * @return integer
     */
    public function getStateTaxAmount()
    {
        return $this->stateTaxAmount;
    }

    /**
     * Set qtyOrdered
     *
     * @param integer $qtyOrdered
     *
     * @return OrdLine
     */
    public function setQtyOrdered($qtyOrdered)
    {
        $this->qtyOrdered = $qtyOrdered;

        return $this;
    }

    /**
     * Get qtyOrdered
     *
     * @return integer
     */
    public function getQtyOrdered()
    {
        return $this->qtyOrdered;
    }

    /**
     * Set qtyAvailable
     *
     * @param integer $qtyAvailable
     *
     * @return OrdLine
     */
    public function setQtyAvailable($qtyAvailable)
    {
        $this->qtyAvailable = $qtyAvailable;

        return $this;
    }

    /**
     * Get qtyAvailable
     *
     * @return integer
     */
    public function getQtyAvailable()
    {
        return $this->qtyAvailable;
    }

    /**
     * Set qtyCanceled
     *
     * @param integer $qtyCanceled
     *
     * @return OrdLine
     */
    public function setQtyCanceled($qtyCanceled)
    {
        $this->qtyCanceled = $qtyCanceled;

        return $this;
    }

    /**
     * Get qtyCanceled
     *
     * @return integer
     */
    public function getQtyCanceled()
    {
        return $this->qtyCanceled;
    }

    /**
     * Set qtyBackordered
     *
     * @param integer $qtyBackordered
     *
     * @return OrdLine
     */
    public function setQtyBackordered($qtyBackordered)
    {
        $this->qtyBackordered = $qtyBackordered;

        return $this;
    }

    /**
     * Get qtyBackordered
     *
     * @return integer
     */
    public function getQtyBackordered()
    {
        return $this->qtyBackordered;
    }

    /**
     * Set qtyAllocated
     *
     * @param integer $qtyAllocated
     *
     * @return OrdLine
     */
    public function setQtyAllocated($qtyAllocated)
    {
        $this->qtyAllocated = $qtyAllocated;

        return $this;
    }

    /**
     * Get qtyAllocated
     *
     * @return integer
     */
    public function getQtyAllocated()
    {
        return $this->qtyAllocated;
    }

    /**
     * Set qtyReserved
     *
     * @param integer $qtyReserved
     *
     * @return OrdLine
     */
    public function setQtyReserved($qtyReserved)
    {
        $this->qtyReserved = $qtyReserved;

        return $this;
    }

    /**
     * Get qtyReserved
     *
     * @return integer
     */
    public function getQtyReserved()
    {
        return $this->qtyReserved;
    }

    /**
     * Set qtyPicked
     *
     * @param integer $qtyPicked
     *
     * @return OrdLine
     */
    public function setQtyPicked($qtyPicked)
    {
        $this->qtyPicked = $qtyPicked;

        return $this;
    }

    /**
     * Get qtyPicked
     *
     * @return integer
     */
    public function getQtyPicked()
    {
        return $this->qtyPicked;
    }

    /**
     * Set qtyShipped
     *
     * @param integer $qtyShipped
     *
     * @return OrdLine
     */
    public function setQtyShipped($qtyShipped)
    {
        $this->qtyShipped = $qtyShipped;

        return $this;
    }

    /**
     * Get qtyShipped
     *
     * @return integer
     */
    public function getQtyShipped()
    {
        return $this->qtyShipped;
    }

    /**
     * Set qtyReturned
     *
     * @param integer $qtyReturned
     *
     * @return OrdLine
     */
    public function setQtyReturned($qtyReturned)
    {
        $this->qtyReturned = $qtyReturned;

        return $this;
    }

    /**
     * Get qtyReturned
     *
     * @return integer
     */
    public function getQtyReturned()
    {
        return $this->qtyReturned;
    }

    /**
     * Set division
     *
     * @param \Orderware\AppBundle\Entity\Division $division
     *
     * @return OrdLine
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
     * Set order
     *
     * @param \Orderware\AppBundle\Entity\OrdHeader $order
     *
     * @return OrdLine
     */
    public function setOrder(\Orderware\AppBundle\Entity\OrdHeader $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Orderware\AppBundle\Entity\OrdHeader
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * Set shipment
     *
     * @param \Orderware\AppBundle\Entity\OrdShip $shipment
     *
     * @return OrdLine
     */
    public function setShipment(\Orderware\AppBundle\Entity\OrdShip $shipment = null)
    {
        $this->shipment = $shipment;

        return $this;
    }

    /**
     * Get shipment
     *
     * @return \Orderware\AppBundle\Entity\OrdShip
     */
    public function getShipment()
    {
        return $this->shipment;
    }

    /**
     * Set item
     *
     * @param \Orderware\AppBundle\Entity\Item $item
     *
     * @return OrdLine
     */
    public function setItem(\Orderware\AppBundle\Entity\Item $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \Orderware\AppBundle\Entity\Item
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set sku
     *
     * @param \Orderware\AppBundle\Entity\ItemSku $sku
     *
     * @return OrdLine
     */
    public function setSku(\Orderware\AppBundle\Entity\ItemSku $sku = null)
    {
        $this->sku = $sku;

        return $this;
    }

    /**
     * Get sku
     *
     * @return \Orderware\AppBundle\Entity\ItemSku
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * Set facility
     *
     * @param \Orderware\AppBundle\Entity\Facility $facility
     *
     * @return OrdLine
     */
    public function setFacility(\Orderware\AppBundle\Entity\Facility $facility = null)
    {
        $this->facility = $facility;

        return $this;
    }

    /**
     * Get facility
     *
     * @return \Orderware\AppBundle\Entity\Facility
     */
    public function getFacility()
    {
        return $this->facility;
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

