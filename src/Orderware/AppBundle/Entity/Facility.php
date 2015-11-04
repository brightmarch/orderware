<?php

namespace Orderware\AppBundle\Entity;

/**
 * Facility
 */
class Facility
{

    /**
     * @var integer
     */
    private $facilityId;

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
    private $facilityCode;

    /**
     * @var string
     */
    private $name;

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
     * @var float
     */
    private $longitude = 0.0;

    /**
     * @var float
     */
    private $latitude = 0.0;

    /**
     * @var integer
     */
    private $unitsPerDay = 0;

    /**
     * @var boolean
     */
    private $isMaster = false;

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
        $facilityCode = (!empty($this->getFacilityCode()) ? $this->getFacilityCode() : 'null');

        return sprintf('Facility (%s)', $facilityCode);
    }

    /**
     * Get facilityId
     *
     * @return integer
     */
    public function getFacilityId()
    {
        return $this->facilityId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Facility
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
     * @return Facility
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
     * @return Facility
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
     * @return Facility
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
     * Set facilityCode
     *
     * @param string $facilityCode
     *
     * @return Facility
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
     * Set name
     *
     * @param string $name
     *
     * @return Facility
     */
    public function setName($name)
    {
        $this->name = $name;

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
     * Set address1
     *
     * @param string $address1
     *
     * @return Facility
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
     * @return Facility
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
     * @return Facility
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
     * @return Facility
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
     * @return Facility
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
     * @return Facility
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
     * @return Facility
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
     * @return Facility
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
     * Set longitude
     *
     * @param float $longitude
     *
     * @return Facility
     */
    public function setLongitude($longitude)
    {
        $this->longitude = (float)$longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     *
     * @return Facility
     */
    public function setLatitude($latitude)
    {
        $this->latitude = (float)$latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }

    /**
     * Set unitsPerDay
     *
     * @param integer $unitsPerDay
     *
     * @return Facility
     */
    public function setUnitsPerDay($unitsPerDay)
    {
        $this->unitsPerDay = (int)$unitsPerDay;

        return $this;
    }

    /**
     * Get unitsPerDay
     *
     * @return integer
     */
    public function getUnitsPerDay()
    {
        return $this->unitsPerDay;
    }

    /**
     * Set isMaster
     *
     * @param boolean $isMaster
     *
     * @return Facility
     */
    public function setIsMaster($isMaster)
    {
        $this->isMaster = (bool)$isMaster;

        return $this;
    }

    /**
     * Get isMaster
     *
     * @return boolean
     */
    public function getIsMaster()
    {
        return $this->isMaster;
    }

    /**
     * Set division
     *
     * @param \Orderware\AppBundle\Entity\Division $division
     *
     * @return Facility
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

    /**
     * Is master
     *
     * @return boolean
     */
    public function isMaster()
    {
        return $this->getIsMaster();
    }

}
