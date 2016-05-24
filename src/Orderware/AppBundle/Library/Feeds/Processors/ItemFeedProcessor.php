<?php

namespace Orderware\AppBundle\Library\Feeds\Processors;

use Orderware\AppBundle\Library\Feeds\Processors\InboundFeedProcessor;

class ItemFeedProcessor extends InboundFeedProcessor
{

    /** @var array */
    private $cache = [ ];

    /** @var array */
    private $feed = [ ];

    public function process() : bool
    {
        $this->loadCache()
            ->processVendors()
            ->processItems();

        return true;
    }

    private function processVendors() : ItemFeedProcessor
    {
        return $this;
    }

    private function processItems() : ItemFeedProcessor
    {
        return $this;
    }

    private function loadCache() : ItemFeedProcessor
    {
        $this->cache = $this->feed = [
            'vendors' => [ ],
            'items' => [ ]
        ];

        return $this;
    }

}
