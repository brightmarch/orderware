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

        foreach ($this->feed['vendors'] as $record) {
            // Grab the primary key for fast cache lookups.
            $vendorNum = $record['vendorNum'];

            try {
                $conn->beginTransaction();

                // Vendor Master
                $vendor = [
                    'account' => $this->account,
                    'updated_at' => Utils::dbDate(),
                    'updated_by' => self::AUTHOR,
                    'vendor_num' => $record['vendorNum'],
                    'display_name' => $record['displayName'],
                    'primary_contact' => $record['primaryContact'],
                    'address1' => $record['address1'],
                    'address2' => $record['address2'],
                    'city_name' => $record['cityName'],
                    'postal_code' => $record['postalCode'],
                    'state_code' => $record['stateCode'],
                    'state_name' => $record['stateName'],
                    'country_code' => $record['countryCode'],
                    'country_name' => $record['countryName'],
                    'email_address' => $record['emailAddress'],
                    'phone_number' => $record['phoneNumber'],
                    'fax_number' => $record['faxNumber'],
                    'notes' => $record['notes']
                ];

                if (($vendorId = $this->getCachedId('vendors', $vendorNum))) {
                    $conn->update('vendor', $vendor, [
                        'vendor_id' => $vendorId
                    ]);
                } else {
                    $vendorId = $conn->fetchColumn("
                        SELECT nextval('vendor_vendor_id_seq')
                    ");

                    $conn->insert('vendor', $vendor + [
                        'vendor_id' => $vendorId,
                        'created_at' => Utils::dbDate(),
                        'created_by' => self::AUTHOR
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
                    'updated_at' => Utils::dbDate(),
                    'updated_by' => self::AUTHOR,
                    'status_id' => $this->statuses[$record['status']],
                    'item_num' => $record['itemNum'],
                    'display_name' => $record['displayName'],
                    'weight' => $record['weight'],
                    'length' => $record['length'],
                    'width' => $record['width'],
                    'depth' => $record['depth'],
                    'is_ship_alone' => Utils::dbBool($record['shipAlone']),
                    'is_taxable' => Utils::dbBool($record['taxable']),
                    'is_virtual' => Utils::dbBool($record['virtual'])
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
                /*
                $query = $conn->createQueryBuilder()
                    ->select('ia.attribute_id', 'ia.attribute')
                    ->from('item_attribute', 'ia')
                    ->where('ia.item_id = ?');

                $attributes = $conn->fetchAll($query->getSQL(), [$itemId]);
                $attributes = array_column(
                    $attributes, 'attribute_id', 'attribute'
                );

                foreach ($record['attributes'] as $attribute => $value) {
                    if (($attributeId = $attributes[$attribute])) {
                    } else {

                    }
                }
                */

                // SKUs
                foreach ($record['skus'] as $record) {
                    // SKU Lookup
                    $query = $conn->createQueryBuilder()
                        ->select('isk.sku_id')
                        ->from('item_sku', 'isk')
                        ->where('isk.item_id = ?')
                        ->andWhere('isk.skucode = ?');

                    $skuId = $conn->fetchColumn($query->getSQL(), [
                        $itemId, $record['skucode']
                    ]);

                    // Vendor Lookup
                    $vendorId = $this->getCachedId(
                        'vendors', $record['vendorNumber']
                    );

                    $sku = [
                        'account' => $this->account,
                        'item_id' => $itemId,
                        'vendor_id' => $vendorId,
                        'status_id' => $this->statuses[$record['status']],
                        'updated_at' => Utils::dbDate(),
                        'updated_by' => self::AUTHOR,
                        'skucode' => $record['skucode'],
                        'cost_price' => $record['costPrice'],
                        'retail_price' => $record['retailPrice'],
                        'pick_description' => $record['pickDescription'],
                        'part_number' => $record['partNumber']
                    ];

                    if ($skuId) {
                        $conn->update('item_sku', $sku, [
                            'sku_id' => $skuId
                        ]);
                    } else {
                        $skuId = $conn->fetchColumn("
                            SELECT nextval('item_sku_sku_id_seq')
                        ");

                        $conn->insert('item_sku', $sku + [
                            'sku_id' => $skuId,
                            'created_at' => Utils::dbDate(),
                            'created_by' => self::AUTHOR
                        ]);
                    }

                    // SKU Attributes

                    // SKU Barcodes
                }

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
                'vendorNum' => $this->xpathLookup('Number'),
                'displayName' => $this->xpathLookup('DisplayName'),
                'primaryContact' => $this->xpathLookup('PrimaryContact'),
                'address1' => $this->xpathLookup('Address1'),
                'address2' => $this->xpathLookup('Address2'),
                'cityName' => $this->xpathLookup('CityName'),
                'postalCode' => $this->xpathLookup('PostalCode'),
                'stateCode' => $this->xpathLookup('StateCode'),
                'stateName' => $this->xpathLookup('StateName'),
                'countryCode' => $this->xpathLookup('CountryCode'),
                'countryName' => $this->xpathLookup('CountryName'),
                'emailAddress' => $this->xpathLookup('EmailAddress'),
                'phoneNumber' => $this->xpathLookup('PhoneNumber'),
                'faxNumber' => $this->xpathLookup('FaxNumber'),
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

                $attribute = $this->xpathLookup('Key');
                $value = $this->xpathLookup('Value');

                $this->feed['items'][$idx]['attributes'][$attribute] = $value;
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

                    $attribute = $this->xpathLookup('Key');
                    $value = $this->xpathLookup('Value');

                    $this->feed['items'][$idx]['skus'][$sdx]['attributes'][$attribute] = $value;
                }

                // Load SKU Barcodes
                $barcodes = $this->xpathRegisterRoot($sku)
                    ->xpathQuery('Barcodes/Barcode');

                foreach ($barcodes as $barcode) {
                    $this->feed['items'][$idx]['skus'][$sdx]['barcodes'][] = $barcode->textContent;
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
