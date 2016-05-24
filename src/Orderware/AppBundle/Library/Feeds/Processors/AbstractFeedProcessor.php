<?php

namespace Orderware\AppBundle\Library\Feeds\Processors;

use Orderware\AppBundle\Entity\FeedLog;

use Doctrine\ORM\EntityManager;

abstract class AbstractFeedProcessor
{

    /** @var Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var Orderware\AppBundle\Entity\FeedLog */
    protected $feedLog;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Processes the feed.
     *
     * @return boolean
     */
    abstract public function process();

    public function isInbound()
    {
        return false;
    }

    public function isOutbound()
    {
        return false;
    }

    public function setFeedLog(FeedLog $feedLog)
    {
        $this->feedLog = $feedLog;

        return $this;
    }

}
