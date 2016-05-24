<?php

namespace Orderware\AppBundle\Library\Feeds\Processors;

use Orderware\AppBundle\Library\Feeds\Processors\AbstractFeedProcessor;

abstract class OutboundFeedProcessor extends AbstractFeedProcessor
{

    public function isOutbound()
    {
        return true;
    }

}
