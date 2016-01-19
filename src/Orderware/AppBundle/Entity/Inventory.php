<?php

namespace Orderware\AppBundle\Entity;

/**
 * Inventory
 */
class Inventory
{

    /**
     * @var integer
     */
    private $inventoryId;

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
    private $qtyReceived = 0;

    /**
     * @var integer
     */
    private $qtyOrdered = 0;

    /**
     * @var integer
     */
    private $qtyShipped = 0;

    /**
     * @var integer
     */
    private $qtyOnhand = 0;

    /**
     * @var integer
     */
    private $qtyAvailable = 0;

    /**
     * @var \Orderware\AppBundle\Entity\Division
     */
    private $division;

    /**
     * @var \Orderware\AppBundle\Entity\Facility
     */
    private $facility;

    /**
     * @var \Orderware\AppBundle\Entity\ItemSku
     */
    private $sku;

    /**
     * Get inventoryId
     *
     * @return integer
     */
    public function getInventoryId()
    {
        return $this->inventoryId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Inventory
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
     * @return Inventory
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
     * @return Inventory
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
     * @return Inventory
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
     * Set qtyReceived
     *
     * @param integer $qtyReceived
     *
     * @return Inventory
     */
    public function setQtyReceived($qtyReceived)
    {
        $this->qtyReceived = (int)$qtyReceived;

        return $this;
    }

    /**
     * Get qtyReceived
     *
     * @return integer
     */
    public function getQtyReceived()
    {
        return $this->qtyReceived;
    }

    /**
     * Set qtyOrdered
     *
     * @param integer $qtyOrdered
     *
     * @return Inventory
     */
    public function setQtyOrdered($qtyOrdered)
    {
        $this->qtyOrdered = (int)$qtyOrdered;

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
     * Set qtyShipped
     *
     * @param integer $qtyShipped
     *
     * @return Inventory
     */
    public function setQtyShipped($qtyShipped)
    {
        $this->qtyShipped = (int)$qtyShipped;

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
     * Set qtyOnhand
     *
     * @param integer $qtyOnhand
     *
     * @return Inventory
     */
    public function setQtyOnhand($qtyOnhand)
    {
        $this->qtyOnhand = (int)$qtyOnhand;

        return $this;
    }

    /**
     * Get qtyOnhand
     *
     * @return integer
     */
    public function getQtyOnhand()
    {
        return $this->qtyOnhand;
    }

    /**
     * Set qtyAvailable
     *
     * @param integer $qtyAvailable
     *
     * @return Inventory
     */
    public function setQtyAvailable($qtyAvailable)
    {
        $this->qtyAvailable = (int)$qtyAvailable;

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
     * Set division
     *
     * @param \Orderware\AppBundle\Entity\Division $division
     *
     * @return Inventory
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
     * Set facility
     *
     * @param \Orderware\AppBundle\Entity\Facility $facility
     *
     * @return Inventory
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
     * Set sku
     *
     * @param \Orderware\AppBundle\Entity\ItemSku $sku
     *
     * @return Inventory
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

}
