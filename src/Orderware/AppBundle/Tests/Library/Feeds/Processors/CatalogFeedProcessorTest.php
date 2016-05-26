<?php

namespace Orderware\AppBundle\Tests\Library\Feeds\Processors;

use Orderware\AppBundle\Tests\TestCase;

class CatalogFeedProcessorTest extends TestCase
{

    public function testIsInbound()
    {
        $processor = $this->getContainer()
            ->get('orderware.feeds.catalog_feed_processor');

        $this->assertTrue($processor->isInbound());
    }

}
