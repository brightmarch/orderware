<?php

namespace Orderware\AppBundle\Library\Feeds;

class FeedProcessor
{

    private $container;

    public function __construct($container)
    {
        $this->container = $container;
    }

    public function process($division, $feedName, $direction)
    {
    }

}
