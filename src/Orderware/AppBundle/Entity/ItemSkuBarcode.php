<?php

namespace Orderware\AppBundle\Entity;

/**
 * ItemSkuBarcode
 */
class ItemSkuBarcode
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
     * @var string
     */
    private $barcode;

    /**
     * @var \Orderware\AppBundle\Entity\Division
     */
    private $division;

    /**
     * @var \Orderware\AppBundle\Entity\ItemSku
     */
    private $itemSku;


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
     * @return ItemSkuBarcode
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
     * @return ItemSkuBarcode
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
     * @return ItemSkuBarcode
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
     * @return ItemSkuBarcode
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
     * Set barcode
     *
     * @param string $barcode
     *
     * @return ItemSkuBarcode
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
     * Set division
     *
     * @param \Orderware\AppBundle\Entity\Division $division
     *
     * @return ItemSkuBarcode
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
     * Set itemSku
     *
     * @param \Orderware\AppBundle\Entity\ItemSku $itemSku
     *
     * @return ItemSkuBarcode
     */
    public function setItemSku(\Orderware\AppBundle\Entity\ItemSku $itemSku = null)
    {
        $this->itemSku = $itemSku;

        return $this;
    }

    /**
     * Get itemSku
     *
     * @return \Orderware\AppBundle\Entity\ItemSku
     */
    public function getItemSku()
    {
        return $this->itemSku;
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

