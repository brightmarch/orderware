<?php

namespace Orderware\AppBundle\Tests\Library\Feeds;

use Orderware\AppBundle\Entity\Feed;
use Orderware\AppBundle\Library\Feeds\ProductProcessor;
use Orderware\AppBundle\Tests\TestCase;

class ProcessorFactoryTest extends TestCase
{

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage A processor for the feed type (invalid) could not be found.
     */
    public function testBuildingProcessorRequiresValidFeedType()
    {
        $this->getContainer()->get('orderware.feed_processor_factory')
            ->build((new Feed)->setFeedType('invalid'));
    }

    public function testBuildingProcessor()
    {
        $processor = $this->getContainer()
            ->get('orderware.feed_processor_factory')
            ->build((new Feed)->setFeedType('product'));

        $this->assertInstanceOf(ProductProcessor::class, $processor);
    }

}
