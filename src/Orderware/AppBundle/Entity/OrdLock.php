<?php

namespace Orderware\AppBundle\Entity;

/**
 * OrdLock
 */
class OrdLock
{

    /**
     * @var integer
     */
    private $ordLockId;

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
    private $lockReason;

    /**
     * @var \DateTime
     */
    private $removedAt;

    /**
     * @var \Orderware\AppBundle\Entity\OrdHeader
     */
    private $order;

    /**
     * Get ordLockId
     *
     * @return integer
     */
    public function getOrdLockId()
    {
        return $this->ordLockId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return OrdLock
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
     * @return OrdLock
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
     * @return OrdLock
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
     * @return OrdLock
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
     * @return OrdLock
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
     * Set lockReason
     *
     * @param string $lockReason
     *
     * @return OrdLock
     */
    public function setLockReason($lockReason)
    {
        $this->lockReason = $lockReason;

        return $this;
    }

    /**
     * Get lockReason
     *
     * @return string
     */
    public function getLockReason()
    {
        return $this->lockReason;
    }

    /**
     * Set removedAt
     *
     * @param \DateTime $removedAt
     *
     * @return OrdLock
     */
    public function setRemovedAt($removedAt)
    {
        $this->removedAt = $removedAt;

        return $this;
    }

    /**
     * Get removedAt
     *
     * @return \DateTime
     */
    public function getRemovedAt()
    {
        return $this->removedAt;
    }

    /**
     * Set order
     *
     * @param \Orderware\AppBundle\Entity\OrdHeader $order
     *
     * @return OrdLock
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
     * Is active
     *
     * @return boolean
     */
    public function isActive()
    {
        return is_null($this->getRemovedAt());
    }

}
