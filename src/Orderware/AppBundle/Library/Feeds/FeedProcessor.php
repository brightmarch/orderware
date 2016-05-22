<?php

namespace Orderware\AppBundle\Library\Feeds;

use Symfony\Component\DependencyInjection\Container;

class FeedProcessor
{

    /** @var Symfony\Component\DependencyInjection\Container */
    private $container;

    /** @var string */
    private $localFile;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function process($account, $direction, $feedName)
    {
        // Get the feed configuration.

        // If inbound, get files.

        // Else if outbound, run feed and generate file.
    }

    public function setLocalFile($localFile)
    {
        $this->localFile = $localFile;

        return $this;
    }

}
