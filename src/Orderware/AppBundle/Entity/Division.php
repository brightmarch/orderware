<?php

namespace Orderware\AppBundle\Entity;

use Orderware\AppBundle\Library\Status;

/**
 * Division
 */
class Division
{

    /**
     * @var string
     */
    private $division;

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
    private $displayName;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var string
     */
    private $timeZone;

    /**
     * @var string
     */
    private $primaryEmail;

    /**
     * @var string
     */
    private $notificationEmail;

    /**
     * @var string
     */
    private $merchDescription;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $users;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getDivision();
    }

    /**
     * Set division
     *
     * @param string $division
     *
     * @return Division
     */
    public function setDivision($division)
    {
        $this->division = strtoupper($division);

        return $this;
    }

    /**
     * Get division
     *
     * @return string
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Division
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
     * @return Division
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
     * @return Division
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
     * @return Division
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
     * @return Division
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
     * Set displayName
     *
     * @param string $displayName
     *
     * @return Division
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
     * Set currency
     *
     * @param string $currency
     *
     * @return Division
     */
    public function setCurrency($currency)
    {
        $this->currency = strtoupper($currency);

        return $this;
    }

    /**
     * Get currency
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * Set timeZone
     *
     * @param string $timeZone
     *
     * @return Division
     */
    public function setTimeZone($timeZone)
    {
        $this->timeZone = $timeZone;

        return $this;
    }

    /**
     * Get timeZone
     *
     * @return string
     */
    public function getTimeZone()
    {
        return $this->timeZone;
    }

    /**
     * Set primaryEmail
     *
     * @param string $primaryEmail
     *
     * @return Division
     */
    public function setPrimaryEmail($primaryEmail)
    {
        $this->primaryEmail = strtolower($primaryEmail);

        return $this;
    }

    /**
     * Get primaryEmail
     *
     * @return string
     */
    public function getPrimaryEmail()
    {
        return $this->primaryEmail;
    }

    /**
     * Set notificationEmail
     *
     * @param string $notificationEmail
     *
     * @return Division
     */
    public function setNotificationEmail($notificationEmail)
    {
        $this->notificationEmail = strtolower($notificationEmail);

        return $this;
    }

    /**
     * Get notificationEmail
     *
     * @return string
     */
    public function getNotificationEmail()
    {
        return $this->notificationEmail;
    }

    /**
     * Set merchDescription
     *
     * @param string $merchDescription
     *
     * @return Division
     */
    public function setMerchDescription($merchDescription)
    {
        $this->merchDescription = $merchDescription;

        return $this;
    }

    /**
     * Get merchDescription
     *
     * @return string
     */
    public function getMerchDescription()
    {
        return $this->merchDescription;
    }

    /**
     * Add user
     *
     * @param \Orderware\AppBundle\Entity\User $user
     *
     * @return Division
     */
    public function addUser(\Orderware\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user
     *
     * @param \Orderware\AppBundle\Entity\User $user
     */
    public function removeUser(\Orderware\AppBundle\Entity\User $user)
    {
        $this->users->removeElement($user);
    }

    /**
     * Get users
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
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
