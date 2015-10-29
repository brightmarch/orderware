<?php

namespace Orderware\AppBundle\Tests\Library\Feeds;

use Orderware\AppBundle\Entity\Feed;
use Orderware\AppBundle\Tests\TestCase;

class ProductProcessorTest extends TestCase
{

    /**
     * @dataProvider providerFeed
     */
    public function testProcessingFeed($feedFile, $recordCount, $hasError)
    {
        $feed = $this->fixtures['product_feed'];
        $feed->setFeedBody(
            file_get_contents(sprintf('%s/%s', __DIR__, $feedFile))
        );

        $processor = $this->getContainer()
            ->get('orderware.feed_processor_product');

        $feed = $processor->run($feed);

        $this->assertEquals($recordCount, $feed->getRecordCount());
        $this->assertSame($hasError, $feed->hasError());
    }

    public function providerFeed()
    {
        $provider = [
            ['feed.product.json', 4, false],
            ['feed.product_duplicates.json', 2, false],
            ['feed.product_invalid.json', 1, true]
        ];

        return $provider;
    }

}
