<?php

namespace Orderware\AppBundle\Library\Feeds\Processors;

use Orderware\AppBundle\Library\Feeds\Processors\InboundFeedProcessor;

class CatalogFeedProcessor extends InboundFeedProcessor
{

    /** @var array */
    private $cache = [ ];

    /** @var array */
    private $feed = [ ];

    public function process() : bool
    {
        $this->logInfo("Starting catalog processing.");

        $this->loadCache()
            ->processVendors()
            ->processItems();

        $this->logInfo("Finished catalog processing.");

        return true;
    }

    private function processVendors() : CatalogFeedProcessor
    {
        return $this;
    }

    private function processItems() : CatalogFeedProcessor
    {
        return $this;
    }

    private function loadCache() : CatalogFeedProcessor
    {
        $this->cache = $this->feed = [
            'vendors' => [ ],
            'items' => [ ]
        ];

        return $this;
    }

}
