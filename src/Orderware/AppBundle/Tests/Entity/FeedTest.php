<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\Feed;
use Orderware\AppBundle\Library\Status;

class FeedTest extends \PHPUnit_Framework_TestCase
{

    public function testSettingDirectionIsLowercased()
    {
        $feed = new Feed;
        $feed->setDirection('INBOUND');

        $this->assertEquals('inbound', $feed->getDirection());
    }

    public function testSettingNameIsLowercased()
    {
        $feed = new Feed;
        $feed->setName('ITEM');

        $this->assertEquals('item', $feed->getName());
    }

    public function testSettingServiceIsLowercased()
    {
        $feed = new Feed;
        $feed->setService('ORDERWARE.ITEM_FEED_PROCESSOR');

        $this->assertEquals('orderware.item_feed_processor', $feed->getService());
    }

    public function testIsEnabled()
    {
        $feed = new Feed;
        $this->assertFalse($feed->isEnabled());

        $feed->setStatusId(Status::ENABLED);
        $this->assertTrue($feed->isEnabled());
    }

    public function testIsInbound()
    {
        $feed = new Feed;
        $this->assertFalse($feed->isInbound());

        $feed->setDirection('inbound');
        $this->assertTrue($feed->isInbound());
    }

    public function testIsOutbound()
    {
        $feed = new Feed;
        $this->assertFalse($feed->isOutbound());

        $feed->setDirection('outbound');
        $this->assertTrue($feed->isOutbound());
    }

    public function testFeedCanOnlyBeInboundOrOutbound()
    {
        $feed = new Feed;
        $this->assertFalse($feed->isInbound());
        $this->assertFalse($feed->isOutbound());

        $feed->setDirection('inbound');
        $this->assertTrue($feed->isInbound());
        $this->assertFalse($feed->isOutbound());

        $feed->setDirection('outbound');
        $this->assertFalse($feed->isInbound());
        $this->assertTrue($feed->isOutbound());
    }

}
