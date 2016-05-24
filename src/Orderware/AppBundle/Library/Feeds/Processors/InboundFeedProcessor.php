<?php

namespace Orderware\AppBundle\Library\Feeds\Processors;

use Orderware\AppBundle\Library\Feeds\AbstractFeed;

abstract class InboundFeedProcessor extends AbstractFeedProcessor
{

    public function isInbound()
    {
        return true;
    }

}
