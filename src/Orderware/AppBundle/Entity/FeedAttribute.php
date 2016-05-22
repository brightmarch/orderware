<?php

namespace Orderware\AppBundle\Entity;

/**
 * FeedAttribute
 */
class FeedAttribute
{

    /**
     * @var integer
     */
    private $attributeId;

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
    private $attribute;

    /**
     * @var string
     */
    private $value;

    /**
     * @var \Orderware\AppBundle\Entity\Feed
     */
    private $feed;

    /**
     * Get attributeId
     *
     * @return integer
     */
    public function getAttributeId()
    {
        return $this->attributeId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return FeedAttribute
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
     * @return FeedAttribute
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
     * @return FeedAttribute
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
     * @return FeedAttribute
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
     * Set attribute
     *
     * @param string $attribute
     *
     * @return FeedAttribute
     */
    public function setAttribute($attribute)
    {
        $this->attribute = strtolower($attribute);

        return $this;
    }

    /**
     * Get attribute
     *
     * @return string
     */
    public function getAttribute()
    {
        return $this->attribute;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return FeedAttribute
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set feed
     *
     * @param \Orderware\AppBundle\Entity\Feed $feed
     *
     * @return FeedAttribute
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

}
