<?php

namespace Orderware\AppBundle\Library\Feeds\Processors;

use Orderware\AppBundle\Entity\Account;
use Orderware\AppBundle\Entity\FeedLog;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\EntityManager;

use \ReflectionClass;

abstract class AbstractFeedProcessor
{

    /** @var Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var Symfony\Component\Validator\Validator\ValidatorInterface */
    protected $validator;

    /** @var Orderware\AppBundle\Entity\Account */
    protected $account;

    /** @var Orderware\AppBundle\Entity\FeedLog */
    protected $feedLog;

    /** @var string */
    protected $contents;

    public function __construct(
        EntityManager $entityManager,
        ValidatorInterface $validator
    )
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
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

    public function setAccount(Account $account)
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

    protected function save($record)
    {
        if ($this->isValid($record)) {
            $this->entityManager
                ->persist($record);

            $this->entityManager
                ->flush($record);
        }

        return true;
    }

    protected function isValid($entity)
    {
        $errors = $this->validator
            ->validate($entity);

        if ($errors->count() > 0) {
            $recordShortName = (new ReflectionClass($entity))
                ->getShortName();

            $message = sprintf("Invalid (%s.%s): %s",
                $recordShortName,
                $errors[0]->getPropertyPath(),
                $errors[0]->getMessage()
            );

            $this->logError($message);

            return false;
        }

        return true;
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

}
