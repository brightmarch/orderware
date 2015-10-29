<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\Feed;
use Orderware\AppBundle\Entity\FeedError;
use Orderware\AppBundle\Library\Status;

class FeedTest extends \PHPUnit_Framework_TestCase
{

    public function testToString()
    {
        $feed = new Feed;
        $this->assertEquals('[] ', $feed->__toString());

        $feed->setFeedType('product');
        $feed->setFileName('product_20150912.json');

        $this->assertEquals('[product] product_20150912.json', $feed->__toString());
    }

    public function testFeedTypeIsLowercased()
    {
        $feed = new Feed;
        $feed->setFeedType('PRODUCT');

        $this->assertEquals('product', $feed->getFeedType());
    }

    public function testHasError()
    {
        $feed = new Feed;
        $this->assertFalse($feed->hasError());

        $feed->setHasError(true);
        $this->assertTrue($feed->hasError());
    }

    public function testIsEnqueued()
    {
        $feed = new Feed;
        $this->assertFalse($feed->isEnqueued());

        $feed->setStatusId(Status::FEED_ENQUEUED);
        $this->assertTrue($feed->isEnqueued());
    }

    public function testIsProcessing()
    {
        $feed = new Feed;
        $this->assertFalse($feed->isProcessing());

        $feed->setStatusId(Status::FEED_PROCESSING);
        $this->assertTrue($feed->isProcessing());
    }

    public function testIsProcessed()
    {
        $feed = new Feed;
        $this->assertFalse($feed->isProcessed());

        $feed->setStatusId(Status::FEED_PROCESSED);
        $this->assertTrue($feed->isProcessed());
    }

    public function testCalculatingIfFeedHasError()
    {
        $feed = new Feed;
        $feed->calculate();

        $this->assertFalse($feed->hasError());

        $feed->setErrorMessage('Invalid feed');
        $feed->calculate();

        $this->assertTrue($feed->hasError());
    }

    public function testCalculatingRunTime()
    {
        $feed = new Feed;
        $this->assertEquals(0, $feed->getRunTime());

        $startedAt = date_create('2015-09-13 01:17:36');
        $finishedAt = date_create('2015-09-13 01:18:47');

        $feed->setStartedAt($startedAt);
        $feed->setFinishedAt($finishedAt);
        $feed->calculate();

        $this->assertEquals(71, $feed->getRunTime());
    }

}
