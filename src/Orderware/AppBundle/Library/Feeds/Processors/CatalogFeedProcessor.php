<?php

namespace Orderware\AppBundle\Library\Feeds\Processors;

use Orderware\AppBundle\Library\Feeds\Processors\InboundFeedProcessor;
use Orderware\AppBundle\Library\Status;
use Orderware\AppBundle\Library\Utils;

use \Exception;

class CatalogFeedProcessor extends InboundFeedProcessor
{

    use Mixin\XmlMixin;

    /** @var array */
    private $cache = [ ];

    /** @var array */
    private $feed = [ ];

    /** @var array */
    private $statuses = [
        'ACTIVE' => Status::ITEM_ACTIVE,
        'INACTIVE' => Status::ITEM_INACTIVE,
    ];

    /** @const string */
    const AUTHOR = 'catalog_feed_processor';

    public function process() : bool
    {
        // Initialze the XML parsers.
        $this->initializeDom();

        $this->initializeCache()
            ->processVendors()
            ->processItems();

        return true;
    }

    private function processVendors() : CatalogFeedProcessor
    {
        $conn = $this->entityManager
            ->getConnection();

        foreach ($this->feed['vendors'] as $vendor) {
            // Grab the primary key for fast cache lookups.
            $vendorNum = $vendor['vendor_num'];

            try {
                $conn->beginTransaction();

                if (($vendorId = $this->getCachedId('vendors', $vendorNum))) {
                    $conn->update('vendor', $vendor + [
                        'updated_at' => Utils::dbDate(),
                        'updated_by' => self::AUTHOR
                    ], ['vendor_id' => $vendorId]);
                } else {
                    $vendorId = $conn->fetchColumn("
                        SELECT nextval('vendor_vendor_id_seq')
                    ");

                    $conn->insert('vendor', $vendor + [
                        'vendor_id' => $vendorId,
                        'created_at' => Utils::dbDate(),
                        'updated_at' => Utils::dbDate(),
                        'created_by' => self::AUTHOR,
                        'updated_by' => self::AUTHOR,
                        'account' => $this->account
                    ]);

                    $this->writeCacheId('vendors', $vendorNum, $vendorId);
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollback();

                $this->logError($e->getMessage());
            }
        }

        return $this;
    }

    private function processItems() : CatalogFeedProcessor
    {
        $conn = $this->entityManager
            ->getConnection();

        foreach ($this->feed['items'] as $record) {
            // Grab the primary key for fast cache lookups.
            $itemNum = $record['itemNum'];

            try {
                $conn->beginTransaction();

                // Item Master
                $item = [
                    'account' => $this->account,
                    'status_id' => $this->statuses[$record['status']],
                    'item_num' => $record['itemNum'],
                    'display_name' => $record['displayName'],
                    'weight' => $record['weight'],
                    'length' => $record['length'],
                    'width' => $record['width'],
                    'depth' => $record['depth'],
                    'is_ship_alone' => Utils::dbBool($record['shipAlone']),
                    'is_taxable' => Utils::dbBool($record['taxable']),
                    'is_virtual' => Utils::dbBool($record['virtual']),
                    'updated_at' => Utils::dbDate(),
                    'updated_by' => self::AUTHOR
                ];

                if (($itemId = $this->getCachedId('items', $itemNum))) {
                    $conn->update('item', $item, [
                        'item_id' => $itemId
                    ]);
                } else {
                    $itemId = $conn->fetchColumn("
                        SELECT nextval('item_item_id_seq')
                    ");

                    $conn->insert('item', $item + [
                        'item_id' => $itemId,
                        'created_at' => Utils::dbDate(),
                        'created_by' => self::AUTHOR
                    ]);

                    $this->writeCacheId('items', $itemNum, $itemId);
                }

                // Item Attributes

                // SKUs

                // SKU Attributes

                // SKU Barcodes

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollback();

                $this->logError($e->getMessage());
            }
        }

        return $this;
    }

    private function initializeCache() : CatalogFeedProcessor
    {
        // Placeholder Arrays
        $this->cache = [
            'vendors' => [ ],
            'items' => [ ]
        ];

        $this->feed = [
            'vendors' => [ ],
            'items' => [ ]
        ];

        // Load Vendors
        $vendors = $this->xpathQuery('//Envelope/Vendors/Vendor');

        foreach ($vendors as $vendor) {
            $this->xpathRegisterRoot($vendor);

            $this->feed['vendors'][] = [
                'vendor_num' => $this->xpathLookup('Number'),
                'display_name' => $this->xpathLookup('DisplayName'),
                'primary_contact' => $this->xpathLookup('PrimaryContact'),
                'address1' => $this->xpathLookup('Address1'),
                'address2' => $this->xpathLookup('Address2'),
                'city_name' => $this->xpathLookup('CityName'),
                'postal_code' => $this->xpathLookup('PostalCode'),
                'state_code' => $this->xpathLookup('StateCode'),
                'state_name' => $this->xpathLookup('StateName'),
                'country_code' => $this->xpathLookup('CountryCode'),
                'country_name' => $this->xpathLookup('CountryName'),
                'email_address' => $this->xpathLookup('EmailAddress'),
                'phone_number' => $this->xpathLookup('PhoneNumber'),
                'fax_number' => $this->xpathLookup('FaxNumber'),
                'notes' => $this->xpathLookup('Notes')
            ];
        }

        // Load Items
        $items = $this->xpathQuery('//Envelope/Items/Item');

        foreach ($items as $idx => $item) {
            $this->xpathRegisterRoot($item);

            $this->feed['items'][$idx] = [
                'itemNum' => $this->xpathLookup('Number'),
                'status' => $this->xpathLookup('Status'),
                'displayName' => $this->xpathLookup('DisplayName'),
                'weight' => (float)$this->xpathLookup('Weight'),
                'length' => (float)$this->xpathLookup('Length'),
                'width' => (float)$this->xpathLookup('Width'),
                'depth' => (float)$this->xpathLookup('Depth'),
                'shipAlone' => $this->xpathLookup('ShipAlone'),
                'taxable' => $this->xpathLookup('Taxable'),
                'virtual' => $this->xpathLookup('Virtual'),
                'attributes' => [ ],
                'skus' => [ ]
            ];

            // Load Item Attributes
            $attributes = $this->xpathRegisterRoot($item)
                ->xpathQuery('Attributes/Attribute');

            foreach ($attributes as $attribute) {
                $this->xpathRegisterRoot($attribute);

                $this->feed['items'][$idx]['attributes'][] = [
                    'attribute' => $this->xpathLookup('Key'),
                    'value' => $this->xpathLookup('Value')
                ];
            }

            // Load Item SKUs
            $skus = $this->xpathRegisterRoot($item)
                ->xpathQuery('Skus/Sku');

            foreach ($skus as $sdx => $sku) {
                $this->xpathRegisterRoot($sku);

                $this->feed['items'][$idx]['skus'][$sdx] = [
                    'skucode' => $this->xpathLookup('Skucode'),
                    'status' => $this->xpathLookup('Status'),
                    'costPrice' => (float)$this->xpathLookup('CostPrice'),
                    'retailPrice' => (float)$this->xpathLookup('RetailPrice'),
                    'pickDescription' => $this->xpathLookup('PickDescription'),
                    'vendorNumber' => $this->xpathLookup('VendorNumber'),
                    'partNumber' => $this->xpathLookup('PartNumber'),
                    'attributes' => [ ],
                    'barcodes' => [ ]
                ];

                // Load SKU Attributes
                $attributes = $this->xpathRegisterRoot($sku)
                    ->xpathQuery('Attributes/Attribute');

                foreach ($attributes as $attribute) {
                    $this->xpathRegisterRoot($attribute);

                    $this->feed['items'][$idx]['skus'][$sdx]['attributes'][] = [
                        'attribute' => $this->xpathLookup('Key'),
                        'value' => $this->xpathLookup('Value')
                    ];
                }

                // Load SKU Barcodes
                $barcodes = $this->xpathRegisterRoot($sku)
                    ->xpathQuery('Barcodes/Barcode');

                foreach ($barcodes as $barcode) {
                    $this->feed['items'][$idx]['skus'][$sdx]['barcodes'][] = [
                        'barcode' => $barcode->textContent
                    ];
                }
            }
        }

        // Cache Vendors
        $query = $this->entityManager
            ->getConnection()
            ->createQueryBuilder()
            ->select('v.vendor_id', 'v.vendor_num')
            ->from('vendor', 'v')
            ->where('v.account = ?');

        $vendors = $this->entityManager
            ->getConnection()
            ->fetchAll($query->getSQL(), [$this->account]);

        $this->cache['vendors'] = array_column(
            $vendors, 'vendor_id', 'vendor_num'
        );

        // Cache Items
        $query = $this->entityManager
            ->getConnection()
            ->createQueryBuilder()
            ->select('i.item_id', 'i.item_num')
            ->from('item', 'i')
            ->where('i.account = ?');

        $items = $this->entityManager
            ->getConnection()
            ->fetchAll($query->getSQL(), [$this->account]);

        $this->cache['items'] = array_column(
            $items, 'item_id', 'item_num'
        );

        return $this;
    }

    private function getCachedId($source, $key)
    {
        if (isset($this->cache[$source][$key])) {
            return $this->cache[$source][$key];
        }

        return null;
    }

    private function writeCacheId($source, $key, $id)
    {
        if (isset($this->cache[$source]) && is_int($id)) {
            $this->cache[$source][$key] = $id;
        }

        return true;
    }

}
