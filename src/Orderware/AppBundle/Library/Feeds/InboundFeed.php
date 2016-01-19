<?php

namespace Orderware\AppBundle\Library\Feeds;

use Orderware\AppBundle\Library\Feeds\AbstractFeed;

abstract class InboundFeed extends AbstractFeed
{

    public function isInbound()
    {
        return true;
    }

}
