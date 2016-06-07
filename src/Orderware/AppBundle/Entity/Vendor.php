<?php

namespace Orderware\AppBundle\Entity;

/**
 * Vendor
 */
class Vendor
{

    /**
     * @var integer
     */
    private $vendorId;

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
    private $vendorNum;

    /**
     * @var string
     */
    private $displayName;

    /**
     * @var string
     */
    private $primaryContact;

    /**
     * @var string
     */
    private $accountNum;

    /**
     * @var string
     */
    private $address1;

    /**
     * @var string
     */
    private $address2;

    /**
     * @var string
     */
    private $cityName;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $stateCode;

    /**
     * @var string
     */
    private $stateName;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $countryName;

    /**
     * @var string
     */
    private $emailAddress;

    /**
     * @var string
     */
    private $faxNumber;

    /**
     * @var string
     */
    private $notes;

    /**
     * @var \Orderware\AppBundle\Entity\Account
     */
    private $account;

    /**
     * Get vendorId
     *
     * @return integer
     */
    public function getVendorId()
    {
        return $this->vendorId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Vendor
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
     * @return Vendor
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
     * @return Vendor
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
     * @return Vendor
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
     * Set vendorNum
     *
     * @param string $vendorNum
     *
     * @return Vendor
     */
    public function setVendorNum($vendorNum)
    {
        $this->vendorNum = $vendorNum;

        return $this;
    }

    /**
     * Get vendorNum
     *
     * @return string
     */
    public function getVendorNum()
    {
        return $this->vendorNum;
    }

    /**
     * Set displayName
     *
     * @param string $displayName
     *
     * @return Vendor
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
     * Set primaryContact
     *
     * @param string $primaryContact
     *
     * @return Vendor
     */
    public function setPrimaryContact($primaryContact)
    {
        $this->primaryContact = $primaryContact;

        return $this;
    }

    /**
     * Get primaryContact
     *
     * @return string
     */
    public function getPrimaryContact()
    {
        return $this->primaryContact;
    }

    /**
     * Set accountNum
     *
     * @param string $accountNum
     *
     * @return Vendor
     */
    public function setAccountNum($accountNum)
    {
        $this->accountNum = $accountNum;

        return $this;
    }

    /**
     * Get accountNum
     *
     * @return string
     */
    public function getAccountNum()
    {
        return $this->accountNum;
    }

    /**
     * Set address1
     *
     * @param string $address1
     *
     * @return Vendor
     */
    public function setAddress1($address1)
    {
        $this->address1 = $address1;

        return $this;
    }

    /**
     * Get address1
     *
     * @return string
     */
    public function getAddress1()
    {
        return $this->address1;
    }

    /**
     * Set address2
     *
     * @param string $address2
     *
     * @return Vendor
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;

        return $this;
    }

    /**
     * Get address2
     *
     * @return string
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * Set cityName
     *
     * @param string $cityName
     *
     * @return Vendor
     */
    public function setCityName($cityName)
    {
        $this->cityName = $cityName;

        return $this;
    }

    /**
     * Get cityName
     *
     * @return string
     */
    public function getCityName()
    {
        return $this->cityName;
    }

    /**
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return Vendor
     */
    public function setPostalCode($postalCode)
    {
        $this->postalCode = $postalCode;

        return $this;
    }

    /**
     * Get postalCode
     *
     * @return string
     */
    public function getPostalCode()
    {
        return $this->postalCode;
    }

    /**
     * Set stateCode
     *
     * @param string $stateCode
     *
     * @return Vendor
     */
    public function setStateCode($stateCode)
    {
        $this->stateCode = $stateCode;

        return $this;
    }

    /**
     * Get stateCode
     *
     * @return string
     */
    public function getStateCode()
    {
        return $this->stateCode;
    }

    /**
     * Set stateName
     *
     * @param string $stateName
     *
     * @return Vendor
     */
    public function setStateName($stateName)
    {
        $this->stateName = $stateName;

        return $this;
    }

    /**
     * Get stateName
     *
     * @return string
     */
    public function getStateName()
    {
        return $this->stateName;
    }

    /**
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return Vendor
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;

        return $this;
    }

    /**
     * Get countryCode
     *
     * @return string
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * Set countryName
     *
     * @param string $countryName
     *
     * @return Vendor
     */
    public function setCountryName($countryName)
    {
        $this->countryName = $countryName;

        return $this;
    }

    /**
     * Get countryName
     *
     * @return string
     */
    public function getCountryName()
    {
        return $this->countryName;
    }

    /**
     * Set emailAddress
     *
     * @param string $emailAddress
     *
     * @return Vendor
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = $emailAddress;

        return $this;
    }

    /**
     * Get emailAddress
     *
     * @return string
     */
    public function getEmailAddress()
    {
        return $this->emailAddress;
    }

    /**
     * Set faxNumber
     *
     * @param string $faxNumber
     *
     * @return Vendor
     */
    public function setFaxNumber($faxNumber)
    {
        $this->faxNumber = $faxNumber;

        return $this;
    }

    /**
     * Get faxNumber
     *
     * @return string
     */
    public function getFaxNumber()
    {
        return $this->faxNumber;
    }

    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return Vendor
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Set account
     *
     * @param \Orderware\AppBundle\Entity\Account $account
     *
     * @return Vendor
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
