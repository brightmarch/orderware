<?php

namespace Orderware\AppBundle\Library\Feeds;

use Doctrine\ORM\EntityManager;

abstract class AbstractFeed
{

    /** @var Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var */
    protected $validator;

    public function __construct(EntityManager $entityManager, $validator)
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
    }

    public function isInbound()
    {
        return false;
    }

    public function isOutbound()
    {
        return false;
    }

    /**
     * Processes the feed.
     *
     * @return boolean
     */
    abstract public function process();

}
