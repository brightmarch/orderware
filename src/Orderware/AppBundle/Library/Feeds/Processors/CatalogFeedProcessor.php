<?php

namespace Orderware\AppBundle\Library\Feeds\Processors;

use Orderware\AppBundle\Library\Feeds\Processors\InboundFeedProcessor;

use \SimpleXMLElement;

class CatalogFeedProcessor extends InboundFeedProcessor
{

    /** @var array */
    private $cache = [ ];

    /** @var array */
    private $feed = [ ];

    public function process() : bool
    {
        $this->initializeCache()
            ->processVendors()
            ->processItems();

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

    private function initializeCache() : CatalogFeedProcessor
    {
        $this->cache = $this->feed = [
            'vendors' => [ ],
            'items' => [ ]
        ];

        /*
        $xml = new SimpleXMLElement($this->contents);

        foreach ($xml->Vendors->Vendor as $vendor) {
            var_dump((string)$vendor->Number);
        }

        foreach ($xml->Items->Item as $item) {
            var_dump((string)$item->Number);
        }
        */

        // Hydrate the cache from the database.

        return $this;
    }

}
