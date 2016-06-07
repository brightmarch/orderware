<?php

namespace Orderware\AppBundle\Entity;

use Orderware\AppBundle\Library\Status;

/**
 * Item
 */
class Item
{

    /**
     * @var integer
     */
    private $itemId;

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
    private $statusId = Status::ITEM_ACTIVE;

    /**
     * @var string
     */
    private $itemNum;

    /**
     * @var string
     */
    private $displayName;

    /**
     * @var float
     */
    private $weight = 0.0;

    /**
     * @var float
     */
    private $length = 0.0;

    /**
     * @var float
     */
    private $width = 0.0;

    /**
     * @var float
     */
    private $depth = 0.0;

    /**
     * @var boolean
     */
    private $isShipAlone = false;

    /**
     * @var boolean
     */
    private $isTaxable = true;

    /**
     * @var boolean
     */
    private $isVirtual = false;

    /**
     * @var boolean
     */
    private $trackInventory = true;

    /**
     * @var \Orderware\AppBundle\Entity\Account
     */
    private $account;

    /**
     * Get itemId
     *
     * @return integer
     */
    public function getItemId()
    {
        return $this->itemId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * @return Item
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
     * Set itemNum
     *
     * @param string $itemNum
     *
     * @return Item
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
     * Set displayName
     *
     * @param string $displayName
     *
     * @return Item
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;

        return $this;
    }

    /**
     * Get displayName
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set weight
     *
     * @param float $weight
     *
     * @return Item
     */
    public function setWeight($weight)
    {
        $this->weight = (float)$weight;

        return $this;
    }

    /**
     * Get weight
     *
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * Set length
     *
     * @param float $length
     *
     * @return Item
     */
    public function setLength($length)
    {
        $this->length = (float)$length;

        return $this;
    }

    /**
     * Get length
     *
     * @return float
     */
    public function getLength()
    {
        return $this->length;
    }

    /**
     * Set width
     *
     * @param float $width
     *
     * @return Item
     */
    public function setWidth($width)
    {
        $this->width = (float)$width;

        return $this;
    }

    /**
     * Get width
     *
     * @return float
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * Set depth
     *
     * @param float $depth
     *
     * @return Item
     */
    public function setDepth($depth)
    {
        $this->depth = (float)$depth;

        return $this;
    }

    /**
     * Get depth
     *
     * @return float
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * Set isShipAlone
     *
     * @param boolean $isShipAlone
     *
     * @return Item
     */
    public function setIsShipAlone($isShipAlone)
    {
        $this->isShipAlone = (bool)$isShipAlone;

        return $this;
    }

    /**
     * Get isShipAlone
     *
     * @return boolean
     */
    public function getIsShipAlone()
    {
        return $this->isShipAlone;
    }

    /**
     * Set isTaxable
     *
     * @param boolean $isTaxable
     *
     * @return Item
     */
    public function setIsTaxable($isTaxable)
    {
        $this->isTaxable = (bool)$isTaxable;

        return $this;
    }

    /**
     * Get isTaxable
     *
     * @return boolean
     */
    public function getIsTaxable()
    {
        return $this->isTaxable;
    }

    /**
     * Set isVirtual
     *
     * @param boolean $isVirtual
     *
     * @return Item
     */
    public function setIsVirtual($isVirtual)
    {
        $this->isVirtual = (bool)$isVirtual;

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
     * Set trackInventory
     *
     * @param boolean $trackInventory
     *
     * @return Item
     */
    public function setTrackInventory($trackInventory)
    {
        $this->trackInventory = (bool)$trackInventory;

        return $this;
    }

    /**
     * Get trackInventory
     *
     * @return boolean
     */
    public function getTrackInventory()
    {
        return $this->trackInventory;
    }

    /**
     * Set account
     *
     * @param \Orderware\AppBundle\Entity\Account $account
     *
     * @return Item
     */
    public function setAccount(\Orderware\AppBundle\Entity\Account $account = null)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * Get account
     *
     * @return \Orderware\AppBundle\Entity\Account
     */
    public function getAccount()
    {
        return $this->account;
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
