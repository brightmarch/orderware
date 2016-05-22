<?php

namespace Orderware\AppBundle\Entity;

/**
 * FeedLogEntry
 */
class FeedLogEntry
{
    /**
     * @var integer
     */
    private $entryId;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @var boolean
     */
    private $isError;

    /**
     * @var string
     */
    private $message;

    /**
     * @var \Orderware\AppBundle\Entity\FeedLog
     */
    private $feedLog;


    /**
     * Get entryId
     *
     * @return integer
     */
    public function getEntryId()
    {
        return $this->entryId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return FeedLogEntry
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
     * @return FeedLogEntry
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
     * Set isError
     *
     * @param boolean $isError
     *
     * @return FeedLogEntry
     */
    public function setIsError($isError)
    {
        $this->isError = $isError;

        return $this;
    }

    /**
     * Get isError
     *
     * @return boolean
     */
    public function getIsError()
    {
        return $this->isError;
    }

    /**
     * Set message
     *
     * @param string $message
     *
     * @return FeedLogEntry
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set feedLog
     *
     * @param \Orderware\AppBundle\Entity\FeedLog $feedLog
     *
     * @return FeedLogEntry
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
