<?php

namespace Orderware\AppBundle\Entity;

use Orderware\AppBundle\Library\Status;

/**
 * OrdImport
 */
class OrdImport
{

    /**
     * @var integer
     */
    private $importId;

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
    private $ordId;

    /**
     * @var integer
     */
    private $statusId;

    /**
     * @var string
     */
    private $orderNum;

    /**
     * @var string
     */
    private $orderBody;

    /**
     * @var integer
     */
    private $runTime = 0;

    /**
     * @var integer
     */
    private $memoryUsage = 0;

    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @var boolean
     */
    private $hasError = false;

    /**
     * @var \Orderware\AppBundle\Entity\Division
     */
    private $division;

    /**
     * Get importId
     *
     * @return integer
     */
    public function getImportId()
    {
        return $this->importId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return OrdImport
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
     * @return OrdImport
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
     * @return OrdImport
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
     * @return OrdImport
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
     * Set ordId
     *
     * @param integer $ordId
     *
     * @return OrdImport
     */
    public function setOrdId($ordId)
    {
        $this->ordId = $ordId;

        return $this;
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
     * Set statusId
     *
     * @param integer $statusId
     *
     * @return OrdImport
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
     * Set orderNum
     *
     * @param string $orderNum
     *
     * @return OrdImport
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
     * Set orderBody
     *
     * @param string $orderBody
     *
     * @return OrdImport
     */
    public function setOrderBody($orderBody)
    {
        $this->orderBody = $orderBody;

        return $this;
    }

    /**
     * Get orderBody
     *
     * @return string
     */
    public function getOrderBody()
    {
        return $this->orderBody;
    }

    /**
     * Set runTime
     *
     * @param integer $runTime
     *
     * @return OrdImport
     */
    public function setRunTime($runTime)
    {
        $this->runTime = (int)$runTime;

        return $this;
    }

    /**
     * Get runTime
     *
     * @return integer
     */
    public function getRunTime()
    {
        return $this->runTime;
    }

    /**
     * Set memoryUsage
     *
     * @param integer $memoryUsage
     *
     * @return OrdImport
     */
    public function setMemoryUsage($memoryUsage)
    {
        $this->memoryUsage = (int)$memoryUsage;

        return $this;
    }

    /**
     * Get memoryUsage
     *
     * @return integer
     */
    public function getMemoryUsage()
    {
        return $this->memoryUsage;
    }

    /**
     * Set errorMessage
     *
     * @param string $errorMessage
     *
     * @return OrdImport
     */
    public function setErrorMessage($errorMessage)
    {
        $this->errorMessage = $errorMessage;

        return $this;
    }

    /**
     * Get errorMessage
     *
     * @return string
     */
    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    /**
     * Set hasError
     *
     * @param boolean $hasError
     *
     * @return OrdImport
     */
    public function setHasError($hasError)
    {
        $this->hasError = (bool)$hasError;

        return $this;
    }

    /**
     * Get hasError
     *
     * @return boolean
     */
    public function getHasError()
    {
        return $this->hasError;
    }

    /**
     * Set division
     *
     * @param \Orderware\AppBundle\Entity\Division $division
     *
     * @return OrdImport
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
        $this->setUpdatedAt(date_create())
            ->setHasError(!empty($this->getErrorMessage()));
    }

    /**
     * Has error
     *
     * @return boolean
     */
    public function hasError()
    {
        return $this->getHasError();
    }

    /**
     * Is enqueued
     *
     * @return boolean
     */
    public function isEnqueued()
    {
        return ($this->getStatusId() === Status::ORDER_IMPORT_ENQUEUED);
    }

    /**
     * Is processing
     *
     * @return boolean
     */
    public function isProcessing()
    {
        return ($this->getStatusId() === Status::ORDER_IMPORT_PROCESSING);
    }

    /**
     * Is processed
     *
     * @return boolean
     */
    public function isProcessed()
    {
        return ($this->getStatusId() === Status::ORDER_IMPORT_PROCESSED);
    }

}
