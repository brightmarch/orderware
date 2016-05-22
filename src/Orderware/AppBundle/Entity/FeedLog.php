<?php

namespace Orderware\AppBundle\Entity;

use Orderware\AppBundle\Entity\FeedLogEntry;
use Orderware\AppBundle\Entity\FeedLogFile;

/**
 * FeedLog
 */
class FeedLog
{

    /**
     * @var integer
     */
    private $logId;

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
    private $fileName;

    /**
     * @var integer
     */
    private $runtime = 0;

    /**
     * @var integer
     */
    private $memoryUsage = 0;

    /**
     * @var boolean
     */
    private $hasError = false;

    /**
     * @var string
     */
    private $errorMessage;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $entries;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $files;

    /**
     * @var \Orderware\AppBundle\Entity\Feed
     */
    private $feed;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->entries = new \Doctrine\Common\Collections\ArrayCollection();
        $this->files = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get logId
     *
     * @return integer
     */
    public function getLogId()
    {
        return $this->logId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return FeedLog
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
     * @return FeedLog
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
     * @return FeedLog
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
     * @return FeedLog
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
     * Set fileName
     *
     * @param string $fileName
     *
     * @return FeedLog
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
     * Set runtime
     *
     * @param integer $runtime
     *
     * @return FeedLog
     */
    public function setRuntime($runtime)
    {
        $this->runtime = (int)$runtime;

        return $this;
    }

    /**
     * Get runtime
     *
     * @return integer
     */
    public function getRuntime()
    {
        return $this->runtime;
    }

    /**
     * Set memoryUsage
     *
     * @param integer $memoryUsage
     *
     * @return FeedLog
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
     * Set hasError
     *
     * @param boolean $hasError
     *
     * @return FeedLog
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
     * Set errorMessage
     *
     * @param string $errorMessage
     *
     * @return FeedLog
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
     * Add entry
     *
     * @param \Orderware\AppBundle\Entity\FeedLogEntry $entry
     *
     * @return FeedLog
     */
    public function addEntry(\Orderware\AppBundle\Entity\FeedLogEntry $entry)
    {
        $this->entries[] = $entry;

        return $this;
    }

    /**
     * Remove entry
     *
     * @param \Orderware\AppBundle\Entity\FeedLogEntry $entry
     */
    public function removeEntry(\Orderware\AppBundle\Entity\FeedLogEntry $entry)
    {
        $this->entries->removeElement($entry);
    }

    /**
     * Get entries
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEntries()
    {
        return $this->entries;
    }

    /**
     * Add file
     *
     * @param \Orderware\AppBundle\Entity\FeedLogFile $file
     *
     * @return FeedLog
     */
    public function addFile(\Orderware\AppBundle\Entity\FeedLogFile $file)
    {
        $this->files[] = $file;

        return $this;
    }

    /**
     * Remove file
     *
     * @param \Orderware\AppBundle\Entity\FeedLogFile $file
     */
    public function removeFile(\Orderware\AppBundle\Entity\FeedLogFile $file)
    {
        $this->files->removeElement($file);
    }

    /**
     * Get files
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set feed
     *
     * @param \Orderware\AppBundle\Entity\Feed $feed
     *
     * @return FeedLog
     */
    public function setFeed(\Orderware\AppBundle\Entity\Feed $feed = null)
    {
        $this->feed = $feed;

        return $this;
    }

    /**
     * Get feed
     *
     * @return \Orderware\AppBundle\Entity\Feed
     */
    public function getFeed()
    {
        return $this->feed;
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
     * Has error
     *
     * @return boolean
     */
    public function hasError() : bool
    {
        return $this->getHasError();
    }

    /**
     * Create file
     *
     * @param string $fileName
     * @param string $contents
     *
     * @return FeedLog
     */
    public function createFile($fileName, $contents) : FeedLog
    {
        $feedLogFile = new FeedLogFile;
        $feedLogFile->setFeedLog($this)
            ->setFileName($fileName)
            ->setFilePath($fileName)
            ->setContents($contents);

        $this->addFile($feedLogFile)
            ->setFileName($fileName);

        return $this;
    }

    /**
     * Log entry
     *
     * @param string $message
     * @param boolean $isError
     *
     * @return FeedLog
     */
    public function logEntry($message, $isError) : FeedLog
    {
        $feedLogEntry = new FeedLogEntry;
        $feedLogEntry->setFeedLog($this)
            ->setIsError($isError)
            ->setMessage($message);

        $this->addEntry($feedLogEntry);

        if ($isError) {
            $this->setHasError(true)
                ->setErrorMessage($message);
        }

        return $this;
    }

}
