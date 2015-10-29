<?php

namespace Orderware\AppBundle\Library\Feeds;

use Orderware\AppBundle\Entity\Feed;

use Symfony\Component\DependencyInjection\Container;

use \InvalidArgumentException;

class ProcessorFactory
{

    /** @var Symfony\Component\DependencyInjection\Container */
    private $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function build(Feed $feed)
    {
        $service = sprintf('orderware.feed_processor_%s', $feed->getFeedType());

        // Return NULL on invalid service so that way we do
        // not have to call has() and get() on the container.
        $processor = $this->container->get(
            $service, Container::NULL_ON_INVALID_REFERENCE
        );

        if (!$processor) {
            throw new InvalidArgumentException(sprintf("A processor for the feed type (%s) could not be found.", $feed->getFeedType()));
        }

        return $processor;
    }

}
