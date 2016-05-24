<?php

namespace Orderware\AppBundle\Tests\Library\Feeds;

use Orderware\AppBundle\Tests\TestCase;

class ProcessorTest extends TestCase
{

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage A feed (inbound:feed) for (INVALID) could not be found.
     */
    public function testProcessingFeedRequiresValidConfiguration()
    {
        $this->getContainer()
            ->get('orderware.feeds.processor')
            ->process('INVALID', 'inbound', 'feed');
    }

    public function testProcessingFeedRequiresItToBeEnabled()
    {
        $feedLog = $this->getContainer()
            ->get('orderware.feeds.processor')
            ->process('GROWERS', 'inbound', 'disabled');

        $this->assertTrue($feedLog->hasError());
        $this->assertEquals("The feed (inbound:disabled) for (GROWERS) is disabled and can not run.", $feedLog->getErrorMessage());
    }

}
