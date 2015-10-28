<?php

namespace Orderware\AppBundle\Entity;

/**
 * Request
 */
class Request
{

    /**
     * @var integer
     */
    private $logId;

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
    private $requestId;

    /**
     * @var string
     */
    private $orderNumber;

    /**
     * @var string
     */
    private $ipAddress;

    /**
     * @var string
     */
    private $requestMethod;

    /**
     * @var string
     */
    private $accept;

    /**
     * @var string
     */
    private $contentType;

    /**
     * @var string
     */
    private $userAgent;

    /**
     * @var string
     */
    private $routeName;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @var string
     */
    private $payload;

    /**
     * @var integer
     */
    private $payloadLength;

    /**
     * @var string
     */
    private $payloadHash;

    /**
     * @var integer
     */
    private $statusCode;

    /**
     * @var string
     */
    private $response;

    /**
     * @var integer
     */
    private $responseLength;

    /**
     * @var string
     */
    private $responseHash;

    /**
     * @var integer
     */
    private $startTime;

    /**
     * @var integer
     */
    private $endTime;

    /**
     * @var integer
     */
    private $totalTime;

    /**
     * @var \Orderware\AppBundle\Entity\Division
     */
    private $division;

    /**
     * @var \Orderware\AppBundle\Entity\User
     */
    private $user;

    /**
     * Get logId
     *
     * @return integer
     */
    public function getLogId()
    {
        return $this->logId;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Request
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
     * @return Request
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
     * @return Request
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
     * @return Request
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
     * Set requestId
     *
     * @param string $requestId
     *
     * @return Request
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;

        return $this;
    }

    /**
     * Get requestId
     *
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * Set orderNumber
     *
     * @param string $orderNumber
     *
     * @return Request
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = strtoupper($orderNumber);

        return $this;
    }

    /**
     * Get orderNumber
     *
     * @return string
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * Set ipAddress
     *
     * @param string $ipAddress
     *
     * @return Request
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }

    /**
     * Get ipAddress
     *
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * Set requestMethod
     *
     * @param string $requestMethod
     *
     * @return Request
     */
    public function setRequestMethod($requestMethod)
    {
        $this->requestMethod = strtoupper($requestMethod);

        return $this;
    }

    /**
     * Get requestMethod
     *
     * @return string
     */
    public function getRequestMethod()
    {
        return $this->requestMethod;
    }

    /**
     * Set accept
     *
     * @param string $accept
     *
     * @return Request
     */
    public function setAccept($accept)
    {
        $this->accept = $accept;

        return $this;
    }

    /**
     * Get accept
     *
     * @return string
     */
    public function getAccept()
    {
        return $this->accept;
    }

    /**
     * Set contentType
     *
     * @param string $contentType
     *
     * @return Request
     */
    public function setContentType($contentType)
    {
        $this->contentType = $contentType;

        return $this;
    }

    /**
     * Get contentType
     *
     * @return string
     */
    public function getContentType()
    {
        return $this->contentType;
    }

    /**
     * Set userAgent
     *
     * @param string $userAgent
     *
     * @return Request
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * Get userAgent
     *
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * Set routeName
     *
     * @param string $routeName
     *
     * @return Request
     */
    public function setRouteName($routeName)
    {
        $this->routeName = $routeName;

        return $this;
    }

    /**
     * Get routeName
     *
     * @return string
     */
    public function getRouteName()
    {
        return $this->routeName;
    }

    /**
     * Set parameters
     *
     * @param array $parameters
     *
     * @return Request
     */
    public function setParameters($parameters)
    {
        $this->parameters = $parameters;

        return $this;
    }

    /**
     * Get parameters
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Set payload
     *
     * @param string $payload
     *
     * @return Request
     */
    public function setPayload($payload)
    {
        $this->payload = $payload;

        return $this;
    }

    /**
     * Get payload
     *
     * @return string
     */
    public function getPayload()
    {
        return $this->payload;
    }

    /**
     * Set payloadLength
     *
     * @param integer $payloadLength
     *
     * @return Request
     */
    public function setPayloadLength($payloadLength)
    {
        $this->payloadLength = $payloadLength;

        return $this;
    }

    /**
     * Get payloadLength
     *
     * @return integer
     */
    public function getPayloadLength()
    {
        return $this->payloadLength;
    }

    /**
     * Set payloadHash
     *
     * @param string $payloadHash
     *
     * @return Request
     */
    public function setPayloadHash($payloadHash)
    {
        $this->payloadHash = $payloadHash;

        return $this;
    }

    /**
     * Get payloadHash
     *
     * @return string
     */
    public function getPayloadHash()
    {
        return $this->payloadHash;
    }

    /**
     * Set statusCode
     *
     * @param integer $statusCode
     *
     * @return Request
     */
    public function setStatusCode($statusCode)
    {
        $this->statusCode = (int)$statusCode;

        return $this;
    }

    /**
     * Get statusCode
     *
     * @return integer
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Set response
     *
     * @param string $response
     *
     * @return Request
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get response
     *
     * @return string
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Set responseLength
     *
     * @param integer $responseLength
     *
     * @return Request
     */
    public function setResponseLength($responseLength)
    {
        $this->responseLength = (int)$responseLength;

        return $this;
    }

    /**
     * Get responseLength
     *
     * @return integer
     */
    public function getResponseLength()
    {
        return $this->responseLength;
    }

    /**
     * Set responseHash
     *
     * @param string $responseHash
     *
     * @return Request
     */
    public function setResponseHash($responseHash)
    {
        $this->responseHash = $responseHash;

        return $this;
    }

    /**
     * Get responseHash
     *
     * @return string
     */
    public function getResponseHash()
    {
        return $this->responseHash;
    }

    /**
     * Set startTime
     *
     * @param integer $startTime
     *
     * @return Request
     */
    public function setStartTime($startTime)
    {
        $this->startTime = (int)$startTime;

        return $this;
    }

    /**
     * Get startTime
     *
     * @return integer
     */
    public function getStartTime()
    {
        return $this->startTime;
    }

    /**
     * Set endTime
     *
     * @param integer $endTime
     *
     * @return Request
     */
    public function setEndTime($endTime)
    {
        $this->endTime = (int)$endTime;

        return $this;
    }

    /**
     * Get endTime
     *
     * @return integer
     */
    public function getEndTime()
    {
        return $this->endTime;
    }

    /**
     * Set totalTime
     *
     * @param integer $totalTime
     *
     * @return Request
     */
    public function setTotalTime($totalTime)
    {
        $this->totalTime = (int)$totalTime;

        return $this;
    }

    /**
     * Get totalTime
     *
     * @return integer
     */
    public function getTotalTime()
    {
        return $this->totalTime;
    }

    /**
     * Set division
     *
     * @param \Orderware\AppBundle\Entity\Division $division
     *
     * @return Request
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
     * Set user
     *
     * @param \Orderware\AppBundle\Entity\User $user
     *
     * @return Request
     */
    public function setUser(\Orderware\AppBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \Orderware\AppBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
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
     * Get totalTimeFormatted
     *
     * @return string
     */
    public function getTotalTimeFormatted()
    {
        return sprintf('%dms', $this->getTotalTime());
    }

    /**
     * Has orderNumber
     *
     * @return boolean
     */
    public function hasOrderNumber()
    {
        return !empty($this->getOrderNumber());
    }

    /**
     * Has payload
     *
     * @return boolean
     */
    public function hasPayload()
    {
        return !empty($this->getPayload());
    }

    /**
     * Has response
     *
     * @return boolean
     */
    public function hasResponse()
    {
        return !empty($this->getResponse());
    }

    /**
     * Copy request
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @return Request
     */
    public function copyRequest(\Symfony\Component\HttpFoundation\Request $request)
    {
        $headers = $request->headers;
        $attributes = $request->attributes;

        $payload = $request->getContent();

        $this->setOrderNumber($attributes->get('orderNumber'))
            ->setIpAddress($request->getClientIp())
            ->setRequestMethod($request->getMethod())
            ->setAccept($headers->get('accept'))
            ->setContentType($headers->get('content-type'))
            ->setUserAgent($headers->get('user-agent'))
            ->setRouteName($attributes->get('_route'))
            ->setParameters($attributes->get('_route_params'))
            ->setPayload($payload)
            ->setPayloadLength(strlen($payload))
            ->setPayloadHash(sha1($payload));

        return $this;
    }

    /**
     * Copy response
     *
     * @param \Symfony\Component\HttpFoundation\Response $response
     * @return Request
     */
    public function copyResponse(\Symfony\Component\HttpFoundation\Response $response)
    {
        $content = $response->getContent();

        $this->setStatusCode($response->getStatusCode())
            ->setResponse($content)
            ->setResponseLength(strlen($content))
            ->setResponseHash(sha1($content));

        return $this;
    }

    /**
     * Start timer
     *
     * @return Request
     */
    public function startTimer()
    {
        $startTime = (int)(microtime(true) * 1000);

        return $this->setStartTime($startTime);
    }

    /**
     * Stop timer
     *
     * @return Request
     */
    public function stopTimer()
    {
        $endTime = (int)(microtime(true) * 1000);
        $totalTime = $endTime - $this->getStartTime();

        return $this->setEndTime($endTime)
            ->setTotalTime($totalTime);
    }

}
