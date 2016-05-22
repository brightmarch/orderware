<?php

namespace Orderware\AppBundle\Entity;

use Orderware\AppBundle\Library\Status;

/**
 * Account
 */
class Account
{

    /**
     * @var string
     */
    private $account;

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
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * To string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getAccount();
    }

    /**
     * Set account
     *
     * @param string $account
     *
     * @return Account
     */
    public function setAccount($account)
    {
        $this->account = strtoupper($account);

        return $this;
    }

    /**
     * Get account
     *
     * @return string
     */
    public function getAccount()
    {
        return $this->account;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Account
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
     * @return Account
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
     * @return Account
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
     * @return Account
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
     * @return Account
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
     * @return Account
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
     * @return Account
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
     * @return Account
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
     * @return Account
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
     * @return Account
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
     * @return Account
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
