<?php

namespace Orderware\AppBundle\Entity;

use Orderware\AppBundle\Library\Status;

use \DateTime;

/**
 * Feed
 */
class Feed
{

    /**
     * @var integer
     */
    private $feedId;

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
    private $feedType;

    /**
     * @var string
     */
    private $fileName;

    /**
     * @var integer
     */
    private $fileSize = 0;

    /**
     * @var string
     */
    private $fileHash;

    /**
     * @var string
     */
    private $manifest;

    /**
     * @var string
     */
    private $feedBody;

    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @var boolean
     */
    private $hasError = false;

    /**
     * @var \DateTime
     */
    private $startedAt;

    /**
     * @var \DateTime
     */
    private $finishedAt;

    /**
     * @var integer
     */
    private $runTime = 0;

    /**
     * @var integer
     */
    private $memoryUsage = 0;

    /**
     * @var integer
     */
    private $recordCount = 0;

    /**
     * @var \Orderware\AppBundle\Entity\Division
     */
    private $division;

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf('[%s] %s', $this->getFeedType(), $this->getFileName());
    }

    /**
     * Get feedId
     *
     * @return integer
     */
    public function getFeedId()
    {
        return $this->feedId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Feed
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
     * @return Feed
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
     * @return Feed
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
     * @return Feed
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
     * @return Feed
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
     * Set feedType
     *
     * @param string $feedType
     *
     * @return Feed
     */
    public function setFeedType($feedType)
    {
        $this->feedType = strtolower($feedType);

        return $this;
    }

    /**
     * Get feedType
     *
     * @return string
     */
    public function getFeedType()
    {
        return $this->feedType;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return Feed
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set fileSize
     *
     * @param integer $fileSize
     *
     * @return Feed
     */
    public function setFileSize($fileSize)
    {
        $this->fileSize = (int)$fileSize;

        return $this;
    }

    /**
     * Get fileSize
     *
     * @return integer
     */
    public function getFileSize()
    {
        return $this->fileSize;
    }

    /**
     * Set fileHash
     *
     * @param string $fileHash
     *
     * @return Feed
     */
    public function setFileHash($fileHash)
    {
        $this->fileHash = $fileHash;

        return $this;
    }

    /**
     * Get fileHash
     *
     * @return string
     */
    public function getFileHash()
    {
        return $this->fileHash;
    }

    /**
     * Set manifest
     *
     * @param string $manifest
     *
     * @return Feed
     */
    public function setManifest($manifest)
    {
        $this->manifest = $manifest;

        return $this;
    }

    /**
     * Get manifest
     *
     * @return string
     */
    public function getManifest()
    {
        return $this->manifest;
    }

    /**
     * Set feedBody
     *
     * @param string $feedBody
     *
     * @return Feed
     */
    public function setFeedBody($feedBody)
    {
        $this->feedBody = $feedBody;

        return $this;
    }

    /**
     * Get feedBody
     *
     * @return string
     */
    public function getFeedBody()
    {
        return $this->feedBody;
    }

    /**
     * Set errorMessage
     *
     * @param string $errorMessage
     *
     * @return Feed
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
     * @return Feed
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
     * Set startedAt
     *
     * @param \DateTime $startedAt
     *
     * @return Feed
     */
    public function setStartedAt($startedAt)
    {
        $this->startedAt = $startedAt;

        return $this;
    }

    /**
     * Get startedAt
     *
     * @return \DateTime
     */
    public function getStartedAt()
    {
        return $this->startedAt;
    }

    /**
     * Set finishedAt
     *
     * @param \DateTime $finishedAt
     *
     * @return Feed
     */
    public function setFinishedAt($finishedAt)
    {
        $this->finishedAt = $finishedAt;

        return $this;
    }

    /**
     * Get finishedAt
     *
     * @return \DateTime
     */
    public function getFinishedAt()
    {
        return $this->finishedAt;
    }

    /**
     * Set runTime
     *
     * @param integer $runTime
     *
     * @return Feed
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
     * @return Feed
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
     * Set recordCount
     *
     * @param integer $recordCount
     *
     * @return Feed
     */
    public function setRecordCount($recordCount)
    {
        $this->recordCount = (int)$recordCount;

        return $this;
    }

    /**
     * Get recordCount
     *
     * @return integer
     */
    public function getRecordCount()
    {
        return $this->recordCount;
    }

    /**
     * Set division
     *
     * @param \Orderware\AppBundle\Entity\Division $division
     *
     * @return Feed
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
            ->setUpdatedAt(date_create())
            ->setStatusId(Status::FEED_ENQUEUED);
    }

    /**
     * @ORM\PreUpdate
     */
    public function onUpdate()
    {
        $this->setUpdatedAt(date_create());
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
        return ($this->getStatusId() === Status::FEED_ENQUEUED);
    }

    /**
     * Is processing
     *
     * @return boolean
     */
    public function isProcessing()
    {
        return ($this->getStatusId() === Status::FEED_PROCESSING);
    }

    /**
     * Is processed
     *
     * @return boolean
     */
    public function isProcessed()
    {
        return ($this->getStatusId() === Status::FEED_PROCESSED);
    }

    /**
     * Calculate
     *
     * @return Feed
     */
    public function calculate()
    {
        if (
            $this->getStartedAt() instanceof DateTime &&
            $this->getFinishedAt() instanceof DateTime
        ) {
            $diff = date_diff($this->getStartedAt(), $this->getFinishedAt());

            // Problem if the feed runs longer than several days.
            $runTime = $diff->s + (
                ($diff->d * 24 * 60 * 60) +
                ($diff->h * 60 * 60) +
                ($diff->i * 60)
            );

            $this->setRunTime($runTime);
        }

        return $this;
    }

}
