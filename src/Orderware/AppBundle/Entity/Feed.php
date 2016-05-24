<?php

namespace Orderware\AppBundle\Entity;

use Orderware\AppBundle\Library\Status;

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
    private $statusId = Status::DISABLED;

    /**
     * @var string
     */
    private $direction;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $service;

    /**
     * @var string
     */
    private $remoteRootDir;

    /**
     * @var string
     */
    private $localRootDir;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $attributes;

    /**
     * @var \Orderware\AppBundle\Entity\Account
     */
    private $account;

    /**
     * @var \Orderware\AppBundle\Entity\FeedConnection
     */
    private $connection;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->attributes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set direction
     *
     * @param string $direction
     *
     * @return Feed
     */
    public function setDirection($direction)
    {
        $this->direction = strtolower($direction);

        return $this;
    }

    /**
     * Get direction
     *
     * @return string
     */
    public function getDirection()
    {
        return $this->direction;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Feed
     */
    public function setName($name)
    {
        $this->name = strtolower($name);

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set service
     *
     * @param string $service
     *
     * @return Feed
     */
    public function setService($service)
    {
        $this->service = strtolower($service);

        return $this;
    }

    /**
     * Get service
     *
     * @return string
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * Set remoteRootDir
     *
     * @param string $remoteRootDir
     *
     * @return Feed
     */
    public function setRemoteRootDir($remoteRootDir)
    {
        $this->remoteRootDir = $remoteRootDir;

        return $this;
    }

    /**
     * Get remoteRootDir
     *
     * @return string
     */
    public function getRemoteRootDir()
    {
        return $this->remoteRootDir;
    }

    /**
     * Set localRootDir
     *
     * @param string $localRootDir
     *
     * @return Feed
     */
    public function setLocalRootDir($localRootDir)
    {
        $this->localRootDir = $localRootDir;

        return $this;
    }

    /**
     * Get localRootDir
     *
     * @return string
     */
    public function getLocalRootDir()
    {
        return $this->localRootDir;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return Feed
     */
    public function setFilename($filename)
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Add attribute
     *
     * @param \Orderware\AppBundle\Entity\FeedAttribute $attribute
     *
     * @return Feed
     */
    public function addAttribute(\Orderware\AppBundle\Entity\FeedAttribute $attribute)
    {
        $this->attributes[] = $attribute;

        return $this;
    }

    /**
     * Remove attribute
     *
     * @param \Orderware\AppBundle\Entity\FeedAttribute $attribute
     */
    public function removeAttribute(\Orderware\AppBundle\Entity\FeedAttribute $attribute)
    {
        $this->attributes->removeElement($attribute);
    }

    /**
     * Get attributes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttributes()
    {
        return $this->attributes;
    }

    /**
     * Set account
     *
     * @param \Orderware\AppBundle\Entity\Account $account
     *
     * @return Feed
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
     * Set connection
     *
     * @param \Orderware\AppBundle\Entity\FeedConnection $connection
     *
     * @return Feed
     */
    public function setConnection(\Orderware\AppBundle\Entity\FeedConnection $connection = null)
    {
        $this->connection = $connection;

        return $this;
    }

    /**
     * Get connection
     *
     * @return \Orderware\AppBundle\Entity\FeedConnection
     */
    public function getConnection()
    {
        return $this->connection;
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
     * Is enabled
     *
     * @return boolean
     */
    public function isEnabled()
    {
        return ($this->getStatusId() === Status::ENABLED);
    }

}
