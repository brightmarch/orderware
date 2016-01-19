<?php

namespace Orderware\AppBundle\Library\Feeds;

use Orderware\AppBundle\Library\Feeds\InboundFeed;
use Orderware\AppBundle\Library\Mixin\ValidationMixin;

class ItemFeed extends InboundFeed
{

    use ValidationMixin;

    public function process()
    {
    }

}
