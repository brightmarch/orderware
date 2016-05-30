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

    /** @var string */
    protected $account;

    /** @var string */
    protected $contents;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Processes the feed.
     *
     * @return boolean
     */
    abstract public function process() : bool;

    public function isInbound()
    {
        return false;
    }

    public function isOutbound()
    {
        return false;
    }

    public function setAccount(string $account)
    {
        $this->account = $account;

        return $this;
    }

    public function setFeedLog(FeedLog $feedLog)
    {
        $this->feedLog = $feedLog;

        return $this;
    }

    public function setContents(string $contents)
    {
        $this->contents = $contents;

        return $this;
    }

    protected function logInfo(string $message)
    {
        $this->feedLog
            ->logEntry($message, false);

        return $this;
    }

    protected function logError(string $message)
    {
        $this->feedLog
            ->logEntry($message, true);

        return $this;
    }

    protected function nextval($sequence)
    {
        return $this->entityManager
            ->getConnection()
            ->getDatabasePlatform()
            ->getSequenceNextValSQL($sequence);
    }

}
