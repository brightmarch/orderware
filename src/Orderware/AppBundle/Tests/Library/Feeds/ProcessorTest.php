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

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The feed (inbound:disabled) for (GROWERS) is disabled and can not run.
     */
    public function testProcessingFeedRequiresItToBeEnabled()
    {
        $feed = $this->fixtures['disabled_feed'];
        $account = $feed->getAccount();

        $this->getContainer()
            ->get('orderware.feeds.processor')
            ->process(
                $account->getAccount(),
                $feed->getDirection(),
                $feed->getName()
            );
    }

}
