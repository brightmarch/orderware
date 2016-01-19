<?php

namespace Orderware\AppBundle\Entity;

/**
 * FeedConfig
 */
class FeedConfig
{

    /**
     * @var integer
     */
    private $configId;

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
    private $name;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $direction;

    /**
     * @var string
     */
    private $service;

    /**
     * @var string
     */
    private $serverHost;

    /**
     * @var string
     */
    private $serverPort;

    /**
     * @var string
     */
    private $serverUsername;

    /**
     * @var string
     */
    private $serverPrivateKey;

    /**
     * @var string
     */
    private $remoteDir;

    /**
     * @var string
     */
    private $localDir;

    /**
     * @var string
     */
    private $environment;

    /**
     * @var string
     */
    private $filename;

    /**
     * @var \Orderware\AppBundle\Entity\Division
     */
    private $division;


    /**
     * Get configId
     *
     * @return integer
     */
    public function getConfigId()
    {
        return $this->configId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return FeedConfig
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
     * @return FeedConfig
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
     * @return FeedConfig
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
     * @return FeedConfig
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
     * Set name
     *
     * @param string $name
     *
     * @return FeedConfig
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
     * Set version
     *
     * @param string $version
     *
     * @return FeedConfig
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * Get version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * Set direction
     *
     * @param string $direction
     *
     * @return FeedConfig
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
     * Set service
     *
     * @param string $service
     *
     * @return FeedConfig
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
     * Set serverHost
     *
     * @param string $serverHost
     *
     * @return FeedConfig
     */
    public function setServerHost($serverHost)
    {
        $this->serverHost = $serverHost;

        return $this;
    }

    /**
     * Get serverHost
     *
     * @return string
     */
    public function getServerHost()
    {
        return $this->serverHost;
    }

    /**
     * Set serverPort
     *
     * @param integer $serverPort
     *
     * @return FeedConfig
     */
    public function setServerPort($serverPort)
    {
        $this->serverPort = (int)$serverPort;

        return $this;
    }

    /**
     * Get serverPort
     *
     * @return integer
     */
    public function getServerPort()
    {
        return $this->serverPort;
    }

    /**
     * Set serverUsername
     *
     * @param string $serverUsername
     *
     * @return FeedConfig
     */
    public function setServerUsername($serverUsername)
    {
        $this->serverUsername = $serverUsername;

        return $this;
    }

    /**
     * Get serverUsername
     *
     * @return string
     */
    public function getServerUsername()
    {
        return $this->serverUsername;
    }

    /**
     * Set serverPrivateKey
     *
     * @param string $serverPrivateKey
     *
     * @return FeedConfig
     */
    public function setServerPrivateKey($serverPrivateKey)
    {
        $this->serverPrivateKey = $serverPrivateKey;

        return $this;
    }

    /**
     * Get serverPrivateKey
     *
     * @return string
     */
    public function getServerPrivateKey()
    {
        return $this->serverPrivateKey;
    }

    /**
     * Set remoteDir
     *
     * @param string $remoteDir
     *
     * @return FeedConfig
     */
    public function setRemoteDir($remoteDir)
    {
        $this->remoteDir = $remoteDir;

        return $this;
    }

    /**
     * Get remoteDir
     *
     * @return string
     */
    public function getRemoteDir()
    {
        return $this->remoteDir;
    }

    /**
     * Set localDir
     *
     * @param string $localDir
     *
     * @return FeedConfig
     */
    public function setLocalDir($localDir)
    {
        $this->localDir = $localDir;

        return $this;
    }

    /**
     * Get localDir
     *
     * @return string
     */
    public function getLocalDir()
    {
        return $this->localDir;
    }

    /**
     * Set environment
     *
     * @param string $environment
     *
     * @return FeedConfig
     */
    public function setEnvironment($environment)
    {
        $this->environment = strtolower($environment);

        return $this;
    }

    /**
     * Get environment
     *
     * @return string
     */
    public function getEnvironment()
    {
        return $this->environment;
    }

    /**
     * Set filename
     *
     * @param string $filename
     *
     * @return FeedConfig
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
     * Set division
     *
     * @param \Orderware\AppBundle\Entity\Division $division
     *
     * @return FeedConfig
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
        $this->setUpdatedAt(date_create());
    }

}
