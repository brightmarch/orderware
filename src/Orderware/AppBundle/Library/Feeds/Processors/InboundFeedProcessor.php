<?php

namespace Orderware\AppBundle\Library\Feeds\Processors;

use Orderware\AppBundle\Library\Feeds\Processors\AbstractFeedProcessor;

abstract class InboundFeedProcessor extends AbstractFeedProcessor
{

    public function isInbound()
    {
        return true;
    }

}
