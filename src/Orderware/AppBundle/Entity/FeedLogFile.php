<?php

namespace Orderware\AppBundle\Entity;

/**
 * FeedLogFile
 */
class FeedLogFile
{

    /**
     * @var integer
     */
    private $fileId;

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
    private $fileName;

    /**
     * @var string
     */
    private $filePath;

    /**
     * @var integer
     */
    private $fileSize = 0;

    /**
     * @var string
     */
    private $contents;

    /**
     * @var \Orderware\AppBundle\Entity\FeedLog
     */
    private $feedLog;


    /**
     * Get fileId
     *
     * @return integer
     */
    public function getFileId()
    {
        return $this->fileId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return FeedLogFile
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
     * @return FeedLogFile
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
     * @return FeedLogFile
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
     * Set filePath
     *
     * @param string $filePath
     *
     * @return FeedLogFile
     */
    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;

        return $this;
    }

    /**
     * Get filePath
     *
     * @return string
     */
    public function getFilePath()
    {
        return $this->filePath;
    }

    /**
     * Set fileSize
     *
     * @param integer $fileSize
     *
     * @return FeedLogFile
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
     * Set contents
     *
     * @param string $contents
     *
     * @return FeedLogFile
     */
    public function setContents($contents)
    {
        $this->setFileSize(strlen($contents));
        $this->contents = $contents;

        return $this;
    }

    /**
     * Get contents
     *
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * Set feedLog
     *
     * @param \Orderware\AppBundle\Entity\FeedLog $feedLog
     *
     * @return FeedLogFile
     */
    public function setFeedLog(\Orderware\AppBundle\Entity\FeedLog $feedLog = null)
    {
        $this->feedLog = $feedLog;

        return $this;
    }

    /**
     * Get feedLog
     *
     * @return \Orderware\AppBundle\Entity\FeedLog
     */
    public function getFeedLog()
    {
        return $this->feedLog;
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
