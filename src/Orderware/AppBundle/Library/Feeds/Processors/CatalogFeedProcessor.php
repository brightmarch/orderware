<?php

namespace Orderware\AppBundle\Library\Feeds\Processors;

use Orderware\AppBundle\Library\Feeds\Processors\InboundFeedProcessor;
use Orderware\AppBundle\Library\Utils;

use \Exception;

class CatalogFeedProcessor extends InboundFeedProcessor
{

    use Mixin\XmlMixin;

    /** @var array */
    private $cache = [ ];

    /** @var array */
    private $feed = [ ];

    /** @const string */
    const AUTHOR = 'catalog_feed_processor';

    public function process() : bool
    {
        $this->initializeCache()
            ->processVendors()
            ->processItems();

        return true;
    }

    private function processVendors() : CatalogFeedProcessor
    {
        $_conn = $this->entityManager
            ->getConnection();

        foreach ($this->feed['vendors'] as $vendor) {
            $vendorNum = $vendor['vendor_num'];

            try {
                $_conn->beginTransaction();

                if (($vendorId = $this->getCachedId('vendors', $vendorNum))) {
                    $_conn->update('vendor', $vendor + [
                        'updated_at' => Utils::dbDate(),
                        'updated_by' => self::AUTHOR
                    ], ['vendor_id' => $vendorId]);
                } else {
                    $vendorId = $_conn->fetchColumn("
                        SELECT nextval('vendor_vendor_id_seq')
                    ");

                    $_conn->insert('vendor', $vendor + [
                        'vendor_id' => $vendorId,
                        'created_at' => Utils::dbDate(),
                        'updated_at' => Utils::dbDate(),
                        'created_by' => self::AUTHOR,
                        'updated_by' => self::AUTHOR,
                        'account' => $this->account
                    ]);

                    $this->writeCachedId('vendors', $vendorNum, $vendorId);
                }

                $_conn->commit();
            } catch (Exception $e) {
                $_conn->rollback();

                $this->logError($e->getMessage());
            }
        }

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

        // Initialze the XML parsers.
        $this->initializeDom();

        // Load Vendors
        $vendors = $this->xpath
            ->query('//Envelope/Vendors/Vendor');

        foreach ($vendors as $vendor) {
            $this->feed['vendors'][] = [
                'vendor_num' => $this->lookupPath('Number', $vendor),
                'display_name' => $this->lookupPath('DisplayName', $vendor),
                'primary_contact' => $this->lookupPath('PrimaryContact', $vendor),
                'address1' => $this->lookupPath('Address1', $vendor),
                'address2' => $this->lookupPath('Address2', $vendor),
                'city_name' => $this->lookupPath('CityName', $vendor),
                'postal_code' => $this->lookupPath('PostalCode', $vendor),
                'state_code' => $this->lookupPath('StateCode', $vendor),
                'state_name' => $this->lookupPath('StateName', $vendor),
                'country_code' => $this->lookupPath('CountryCode', $vendor),
                'country_name' => $this->lookupPath('CountryName', $vendor),
                'email_address' => $this->lookupPath('EmailAddress', $vendor),
                'phone_number' => $this->lookupPath('PhoneNumber', $vendor),
                'fax_number' => $this->lookupPath('FaxNumber', $vendor),
                'notes' => $this->lookupPath('Notes', $vendor)
            ];
        }

        // Load Items

        // Cache Vendors
        $sql = "SELECT v.* FROM vendor v WHERE v.account = ?";

        $vendors = $this->entityManager
            ->getConnection()
            ->fetchAll($sql, [$this->account]);

        $this->cache['vendors'] = array_column(
            $vendors, 'vendor_id', 'vendor_num'
        );

        // Cache Items

        return $this;
    }

    private function getCachedId($source, $key)
    {
        if (isset($this->cache[$source][$key])) {
            return $this->cache[$source][$key];
        }

        return null;
    }

    private function writeCachedId($source, $key, $id)
    {
        if (isset($this->cache[$source]) && is_int($id)) {
            $this->cache[$source][$key] = $id;
        }

        return true;
    }

}
