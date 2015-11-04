<?php

namespace Orderware\AppBundle\Entity;

/**
 * OrdPay
 */
class OrdPay
{

    /**
     * @var integer
     */
    private $ordPayId;

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
    private $payMethod;

    /**
     * @var integer
     */
    private $payAmount;

    /**
     * @var integer
     */
    private $settledAmount;

    /**
     * @var string
     */
    private $transactionCode;

    /**
     * @var string
     */
    private $currency;

    /**
     * @var \Orderware\AppBundle\Entity\Division
     */
    private $division;

    /**
     * @var \Orderware\AppBundle\Entity\OrdHeader
     */
    private $order;

    /**
     * Get ordPayId
     *
     * @return integer
     */
    public function getOrdPayId()
    {
        return $this->ordPayId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return OrdPay
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
     * @return OrdPay
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
     * @return OrdPay
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
     * @return OrdPay
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
     * Set payMethod
     *
     * @param string $payMethod
     *
     * @return OrdPay
     */
    public function setPayMethod($payMethod)
    {
        $this->payMethod = strtoupper($payMethod);

        return $this;
    }

    /**
     * Get payMethod
     *
     * @return string
     */
    public function getPayMethod()
    {
        return $this->payMethod;
    }

    /**
     * Set payAmount
     *
     * @param integer $payAmount
     *
     * @return OrdPay
     */
    public function setPayAmount($payAmount)
    {
        $this->payAmount = (int)$payAmount;

        return $this;
    }

    /**
     * Get payAmount
     *
     * @return integer
     */
    public function getPayAmount()
    {
        return $this->payAmount;
    }

    /**
     * Set settledAmount
     *
     * @param integer $settledAmount
     *
     * @return OrdPay
     */
    public function setSettledAmount($settledAmount)
    {
        $this->settledAmount = (int)$settledAmount;

        return $this;
    }

    /**
     * Get settledAmount
     *
     * @return integer
     */
    public function getSettledAmount()
    {
        return $this->settledAmount;
    }

    /**
     * Set transactionCode
     *
     * @param string $transactionCode
     *
     * @return OrdPay
     */
    public function setTransactionCode($transactionCode)
    {
        $this->transactionCode = $transactionCode;

        return $this;
    }

    /**
     * Get transactionCode
     *
     * @return string
     */
    public function getTransactionCode()
    {
        return $this->transactionCode;
    }

    /**
     * Set currency
     *
     * @param string $currency
     *
     * @return OrdPay
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
     * Set division
     *
     * @param \Orderware\AppBundle\Entity\Division $division
     *
     * @return OrdPay
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
     * @return OrdPay
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

}
