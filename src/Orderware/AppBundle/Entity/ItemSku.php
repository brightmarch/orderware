<?php

namespace Orderware\AppBundle\Entity;

/**
 * ItemSku
 */
class ItemSku
{

    /**
     * @var integer
     */
    private $skuId;

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
    private $skucode;

    /**
     * @var string
     */
    private $barcode;

    /**
     * @var integer
     */
    private $costPrice = 0;

    /**
     * @var integer
     */
    private $retailPrice = 0;

    /**
     * @var string
     */
    private $pickDescription;

    /**
     * @var \Orderware\AppBundle\Entity\Division
     */
    private $division;

    /**
     * @var \Orderware\AppBundle\Entity\Item
     */
    private $item;

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        $skucode = (!empty($this->getSkucode()) ? $this->getSkucode() : 'null');

        return sprintf('SKU (%s)', $skucode);
    }

    /**
     * Get skuId
     *
     * @return integer
     */
    public function getSkuId()
    {
        return $this->skuId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return ItemSku
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
     * @return ItemSku
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
     * @return ItemSku
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
     * @return ItemSku
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
     * @return ItemSku
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
     * Set skucode
     *
     * @param string $skucode
     *
     * @return ItemSku
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
     * Set barcode
     *
     * @param string $barcode
     *
     * @return ItemSku
     */
    public function setBarcode($barcode)
    {
        $this->barcode = $barcode;

        return $this;
    }

    /**
     * Get barcode
     *
     * @return string
     */
    public function getBarcode()
    {
        return $this->barcode;
    }

    /**
     * Set costPrice
     *
     * @param integer $costPrice
     *
     * @return ItemSku
     */
    public function setCostPrice($costPrice)
    {
        $this->costPrice = (int)$costPrice;

        return $this;
    }

    /**
     * Get costPrice
     *
     * @return integer
     */
    public function getCostPrice()
    {
        return $this->costPrice;
    }

    /**
     * Set retailPrice
     *
     * @param integer $retailPrice
     *
     * @return ItemSku
     */
    public function setRetailPrice($retailPrice)
    {
        $this->retailPrice = (int)$retailPrice;

        return $this;
    }

    /**
     * Get retailPrice
     *
     * @return integer
     */
    public function getRetailPrice()
    {
        return $this->retailPrice;
    }

    /**
     * Set pickDescription
     *
     * @param string $pickDescription
     *
     * @return ItemSku
     */
    public function setPickDescription($pickDescription)
    {
        $this->pickDescription = strtoupper($pickDescription);

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
     * Set division
     *
     * @param \Orderware\AppBundle\Entity\Division $division
     *
     * @return ItemSku
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
     * Set item
     *
     * @param \Orderware\AppBundle\Entity\Item $item
     *
     * @return ItemSku
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