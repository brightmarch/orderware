<?php

namespace Orderware\AppBundle\Library\Feeds\Processors;

use Orderware\AppBundle\Entity\Item;
use Orderware\AppBundle\Entity\ItemAttribute;
use Orderware\AppBundle\Entity\ItemSku;
use Orderware\AppBundle\Entity\ItemSkuAttribute;
use Orderware\AppBundle\Entity\ItemSkuBarcode;
use Orderware\AppBundle\Entity\Vendor;
use Orderware\AppBundle\Library\Feeds\Processors\InboundFeedProcessor;
use Orderware\AppBundle\Library\Status;
use Orderware\AppBundle\Library\Utils;

use \Exception;

class CatalogFeedProcessor extends InboundFeedProcessor
{

    use Mixin\XmlMixin;

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

        $this->processVendors()
            ->processItems();

        return true;
    }

    private function processVendors() : CatalogFeedProcessor
    {
        $vendors = $this->xpathQuery('//Envelope/Vendors/Vendor');

        foreach ($vendors as $vendor) {
            $this->xpathRegisterRoot($vendor);

            // Primary Key
            $vendorNum = $this->xpathLookup('Number');

            // Vendor Search
            $vendor = $this->entityManager
                ->getRepository('Orderware:Vendor')
                ->findOneBy([
                    'account' => $this->account,
                    'vendorNum' => $vendorNum
                ]);

            if (!$vendor) {
                $vendor = new Vendor;
                $vendor->setAccount($this->account)
                    ->setCreatedBy(self::AUTHOR)
                    ->setVendorNum($vendorNum);
            }

            $vendor->setUpdatedBy(self::AUTHOR)
                ->setDisplayName($this->xpathLookup('DisplayName'))
                ->setPrimaryContact($this->xpathLookup('PrimaryContact'))
                ->setAddress1($this->xpathLookup('Address1'))
                ->setAddress2($this->xpathLookup('Address2'))
                ->setCityName($this->xpathLookup('CityName'))
                ->setPostalCode($this->xpathLookup('PostalCode'))
                ->setStateCode($this->xpathLookup('StateCode'))
                ->setStateName($this->xpathLookup('StateName'))
                ->setCountryCode($this->xpathLookup('CountryCode'))
                ->setCountryName($this->xpathLookup('CountryName'))
                ->setEmailAddress($this->xpathLookup('EmailAddress'))
                ->setPhoneNumber($this->xpathLookup('PhoneNumber'))
                ->setFaxNumber($this->xpathLookup('FaxNumber'))
                ->setNotes($this->xpathLookup('Notes'));

            $this->save($vendor);
        }

        return $this;
    }

    private function processItems() : CatalogFeedProcessor
    {
        $items = $this->xpathQuery('//Envelope/Items/Item');

        foreach ($items as $item) {
            $this->xpathRegisterRoot($item);

            // Primary Key
            $itemNum = $this->xpathLookup('Number');

            // Item Search
            $item = $this->entityManager
                ->getRepository('Orderware:Item')
                ->findOneBy([
                    'account' => $this->account,
                    'itemNum' => $itemNum
                ]);

            if (!$item) {
                $item = new Item;
                $item->setAccount($this->account)
                    ->setCreatedBy(self::AUTHOR)
                    ->setItemNum($itemNum);
            }

            $item->setUpdatedBy(self::AUTHOR)
                ->setDisplayName($this->xpathLookup('DisplayName'))
                ->setWeight($this->xpathLookup('Weight'))
                ->setLength($this->xpathLookup('Length'))
                ->setWidth($this->xpathLookup('Width'))
                ->setDepth($this->xpathLookup('Depth'))
                ->setIsShipAlone(Utils::dbBool($this->xpathLookup('ShipAlone')))
                ->setIsTaxable(Utils::dbBool($this->xpathLookup('Taxable')))
                ->setIsVirtual(Utils::dbBool($this->xpathLookup('Virtual')))
                ->setTrackInventory(true);

            // Item Attributes

            // SKUs

            // SKU Attributes

            // SKU Barcodes

            $this->save($item);
        }

        /*
        foreach ($this->feed['items'] as $record) {
            // Grab the primary key for fast cache lookups.
            $itemNum = $record['itemNum'];

            try {
                // Item Attributes
                foreach ($record['attributes'] as $attribute => $value) {
                    $query = $conn->createQueryBuilder()
                        ->select('ia.attribute_id')
                        ->from('item_attribute', 'ia')
                        ->where('ia.item_id = ?')
                        ->andWhere('ia.attribute = ?');

                    $attributeId = $conn->fetchColumn($query->getSQL(), [
                        $itemId, $attribute
                    ]);

                    // Attribute Record
                    $attribute = [
                        'item_id' => $itemId,
                        'updated_at' => Utils::dbDate(),
                        'updated_by' => self::AUTHOR,
                        'attribute' => $attribute,
                        'value' => $value
                    ];

                    if ($attributeId) {
                        $conn->update('item_attribute', $attribute, [
                            'attribute_id' => $attributeId
                        ]);
                    } else {
                        $attributeId = $conn->fetchColumn(
                            $this->nextval('item_attribute_attribute_id_seq')
                        );

                        $conn->insert('item_attribute', $attribute + [
                            'attribute_id' => $attributeId,
                            'created_at' => Utils::dbDate(),
                            'created_by' => self::AUTHOR
                        ]);
                    }
                }

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

                    // SKU Record
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
                        $skuId = $conn->fetchColumn(
                            $this->nextval('item_sku_sku_id_seq')
                        );

                        $conn->insert('item_sku', $sku + [
                            'sku_id' => $skuId,
                            'created_at' => Utils::dbDate(),
                            'created_by' => self::AUTHOR
                        ]);
                    }

                    // SKU Attributes
                    foreach ($record['attributes'] as $attribute => $value) {
                        $query = $conn->createQueryBuilder()
                            ->select('isa.attribute_id')
                            ->from('item_sku_attribute', 'isa')
                            ->where('isa.sku_id = ?')
                            ->andWhere('isa.attribute = ?');

                        $attributeId = $conn->fetchColumn($query->getSQL(), [
                            $skuId, $attribute
                        ]);

                        // Attribute Record
                        $attribute = [
                            'sku_id' => $skuId,
                            'updated_at' => Utils::dbDate(),
                            'updated_by' => self::AUTHOR,
                            'attribute' => $attribute,
                            'value' => $value
                        ];

                        if ($attributeId) {
                            $conn->update('item_sku_attribute', $attribute, [
                                'attribute_id' => $attributeId
                            ]);
                        } else {
                            $attributeId = $conn->fetchColumn(
                                $this->nextval('item_sku_attribute_attribute_id_seq')
                            );

                            $conn->insert('item_sku_attribute', $attribute + [
                                'attribute_id' => $attributeId,
                                'created_at' => Utils::dbDate(),
                                'created_by' => self::AUTHOR
                            ]);
                        }
                    }

                    // SKU Barcodes
                    foreach ($record['barcodes'] as $barcode) {
                        $query = $conn->createQueryBuilder()
                            ->select('isb.barcode_id')
                            ->from('item_sku_barcode', 'isb')
                            ->where('isb.account = ?')
                            ->andWhere('isb.barcode = ?');

                        $barcodeId = $conn->fetchColumn($query->getSQL(), [
                            $this->account, $barcode
                        ]);

                        // Barcode Record
                        $barcode = [
                            'account' => $this->account,
                            'sku_id' => $skuId,
                            'updated_at' => Utils::dbDate(),
                            'updated_by' => self::AUTHOR,
                            'barcode' => $barcode
                        ];

                        if ($barcodeId) {
                            $conn->update('item_sku_barcode', $barcode, [
                                'barcode_id' => $barcodeId
                            ]);
                        } else {
                            $barcodeId = $conn->fetchColumn(
                                $this->nextval('item_sku_barcode_barcode_id_seq')
                            );

                            $conn->insert('item_sku_barcode', $barcode + [
                                'barcode_id' => $barcodeId,
                                'created_at' => Utils::dbDate(),
                                'created_by' => self::AUTHOR
                            ]);
                        }
                    }
                }

                $conn->commit();
            } catch (Exception $e) {
                $conn->rollback();

                $this->logError($e->getMessage());
            }
        }
        */

        return $this;
    }

    private function initializeCache() : CatalogFeedProcessor
    {
        /*
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
        */

        return $this;
    }

}
