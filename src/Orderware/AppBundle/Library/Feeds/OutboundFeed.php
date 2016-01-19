<?php

namespace Orderware\AppBundle\Library\Feeds;

use Orderware\AppBundle\Library\Feeds\AbstractFeed;

abstract class OutboundFeed extends AbstractFeed
{

    public function isOutbound()
    {
        return true;
    }

}
