<?php

namespace Orderware\AppBundle\Tests\Library\Feeds\Processors;

use Orderware\AppBundle\Tests\TestCase;

class ItemFeedProcessorTest extends TestCase
{

    public function testIsInbound()
    {
        $processor = $this->getContainer()
            ->get('orderware.feeds.item_feed_processor');

        $this->assertTrue($processor->isInbound());
    }

}
