<?php

namespace Orderware\AppBundle\Entity;

/**
 * OrdShip
 */
class OrdShip
{

    /**
     * @var integer
     */
    private $ordShipId;

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
    private $shipMethod;

    /**
     * @var string
     */
    private $firstName;

    /**
     * @var string
     */
    private $middleName;

    /**
     * @var string
     */
    private $lastName;

    /**
     * @var string
     */
    private $fullName;

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
    private $stateName;

    /**
     * @var string
     */
    private $stateCode;

    /**
     * @var string
     */
    private $postalCode;

    /**
     * @var string
     */
    private $countryName;

    /**
     * @var string
     */
    private $countryCode;

    /**
     * @var string
     */
    private $companyName;

    /**
     * @var string
     */
    private $emailAddress;

    /**
     * @var string
     */
    private $phoneNumber;

    /**
     * @var string
     */
    private $notifyBy;

    /**
     * @var boolean
     */
    private $notificationEnabled = true;

    /**
     * @var string
     */
    private $facilityCode;

    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $lines;

    /**
     * @var \Orderware\AppBundle\Entity\Division
     */
    private $division;

    /**
     * @var \Orderware\AppBundle\Entity\OrdHeader
     */
    private $order;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->lines = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get ordShipId
     *
     * @return integer
     */
    public function getOrdShipId()
    {
        return $this->ordShipId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return OrdShip
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
     * @return OrdShip
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
     * @return OrdShip
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
     * @return OrdShip
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
     * Set shipMethod
     *
     * @param string $shipMethod
     *
     * @return OrdShip
     */
    public function setShipMethod($shipMethod)
    {
        $this->shipMethod = strtoupper($shipMethod);

        return $this;
    }

    /**
     * Get shipMethod
     *
     * @return string
     */
    public function getShipMethod()
    {
        return $this->shipMethod;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return OrdShip
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set middleName
     *
     * @param string $middleName
     *
     * @return OrdShip
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get middleName
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return OrdShip
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set fullName
     *
     * @param string $fullName
     *
     * @return OrdShip
     */
    public function setFullName($fullName)
    {
        $this->fullName = $fullName;

        return $this;
    }

    /**
     * Get fullName
     *
     * @return string
     */
    public function getFullName()
    {
        return $this->fullName;
    }

    /**
     * Set address1
     *
     * @param string $address1
     *
     * @return OrdShip
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
     * @return OrdShip
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
     * @return OrdShip
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
     * Set stateName
     *
     * @param string $stateName
     *
     * @return OrdShip
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
     * Set stateCode
     *
     * @param string $stateCode
     *
     * @return OrdShip
     */
    public function setStateCode($stateCode)
    {
        $this->stateCode = strtoupper($stateCode);

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
     * Set postalCode
     *
     * @param string $postalCode
     *
     * @return OrdShip
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
     * Set countryName
     *
     * @param string $countryName
     *
     * @return OrdShip
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
     * Set countryCode
     *
     * @param string $countryCode
     *
     * @return OrdShip
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = strtoupper($countryCode);

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
     * Set companyName
     *
     * @param string $companyName
     *
     * @return OrdShip
     */
    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;

        return $this;
    }

    /**
     * Get companyName
     *
     * @return string
     */
    public function getCompanyName()
    {
        return $this->companyName;
    }

    /**
     * Set emailAddress
     *
     * @param string $emailAddress
     *
     * @return OrdShip
     */
    public function setEmailAddress($emailAddress)
    {
        $this->emailAddress = strtolower($emailAddress);

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
     * Set phoneNumber
     *
     * @param string $phoneNumber
     *
     * @return OrdShip
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * Get phoneNumber
     *
     * @return string
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * Set notifyBy
     *
     * @param string $notifyBy
     *
     * @return OrdShip
     */
    public function setNotifyBy($notifyBy)
    {
        $this->notifyBy = strtolower($notifyBy);

        return $this;
    }

    /**
     * Get notifyBy
     *
     * @return string
     */
    public function getNotifyBy()
    {
        return $this->notifyBy;
    }

    /**
     * Set notificationEnabled
     *
     * @param boolean $notificationEnabled
     *
     * @return OrdShip
     */
    public function setNotificationEnabled($notificationEnabled)
    {
        $this->notificationEnabled = (bool)$notificationEnabled;

        return $this;
    }

    /**
     * Get notificationEnabled
     *
     * @return boolean
     */
    public function getNotificationEnabled()
    {
        return $this->notificationEnabled;
    }

    /**
     * Set facilityCode
     *
     * @param string $facilityCode
     *
     * @return OrdShip
     */
    public function setFacilityCode($facilityCode)
    {
        $this->facilityCode = strtoupper($facilityCode);

        return $this;
    }

    /**
     * Get facilityCode
     *
     * @return string
     */
    public function getFacilityCode()
    {
        return $this->facilityCode;
    }

    /**
     * Add line
     *
     * @param \Orderware\AppBundle\Entity\OrdLine $line
     *
     * @return OrdShip
     */
    public function addLine(\Orderware\AppBundle\Entity\OrdLine $line)
    {
        $this->lines[] = $line;

        return $this;
    }

    /**
     * Remove line
     *
     * @param \Orderware\AppBundle\Entity\OrdLine $line
     */
    public function removeLine(\Orderware\AppBundle\Entity\OrdLine $line)
    {
        $this->lines->removeElement($line);
    }

    /**
     * Get lines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLines()
    {
        return $this->lines;
    }

    /**
     * Set division
     *
     * @param \Orderware\AppBundle\Entity\Division $division
     *
     * @return OrdShip
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
     * Set order
     *
     * @param \Orderware\AppBundle\Entity\OrdHeader $order
     *
     * @return OrdShip
     */
    public function setOrder(\Orderware\AppBundle\Entity\OrdHeader $order = null)
    {
        $this->order = $order;

        return $this;
    }

    /**
     * Get order
     *
     * @return \Orderware\AppBundle\Entity\OrdHeader
     */
    public function getOrder()
    {
        return $this->order;
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
     * Has facilityCode
     *
     * @return boolean
     */
    public function hasFacilityCode()
    {
        return !empty($this->getFacilityCode());
    }

}
