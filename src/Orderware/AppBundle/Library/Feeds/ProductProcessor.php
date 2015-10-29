<?php

namespace Orderware\AppBundle\Library\Feeds;

use Orderware\AppBundle\Library\Feeds\AbstractProcessor;
use Orderware\AppBundle\Library\Status;
use Orderware\AppBundle\Library\Utils;

use Symfony\Component\Validator\Constraints as Assert;

class ProductProcessor extends AbstractProcessor
{

    /** @const string */
    const AUTHOR = 'product_processor';

    protected function process()
    {
        $this->loadRecords('vendors')
            ->loadRecords('items')
            ->loadRecords('skus');

        foreach ($this->feedBody->vendors as $_vend) {
            $vendorId = Utils::arrayValue(
                $this->records['vendors'], $_vend->vendor_num
            );

            $vendor = [
                'vendor_id' => $vendorId,
                'updated_at' => Utils::dbDate(),
                'updated_by' => self::AUTHOR,
                'division' => $this->division,
                'vendor_num' => $_vend->vendor_num,
                'display_name' => $_vend->display_name,
                'primary_contact' => $_vend->primary_contact,
                'address1' => $_vend->address1,
                'address2' => $_vend->address2,
                'city_name' => $_vend->city_name,
                'postal_code' => $_vend->postal_code,
                'state_code' => $_vend->state_code,
                'state_name' => $_vend->state_name,
                'country_code' => $_vend->country_code,
                'country_name' => $_vend->country_name,
                'phone_number' => $_vend->phone_number,
                'email_address' => $_vend->email_address,
                'fax_number' => $_vend->fax_number
            ];

            $this->saveRecord('vendors', $vendor);
        }

        foreach ($this->feedBody->items as $_item) {
            $itemId = Utils::arrayValue(
                $this->records['items'], $_item->item_num
            );

            $item = [
                'item_id' => $itemId,
                'updated_at' => Utils::dbDate(),
                'updated_by' => self::AUTHOR,
                'division' => $this->division,
                'status_id' => Status::ITEM_AVAILABLE,
                'item_num' => $_item->item_num,
                'display_name' => $_item->display_name,
                'weight' => $_item->weight,
                'length' => $_item->length,
                'width' => $_item->width,
                'depth' => $_item->depth,
                'is_ship_alone' => Utils::dbBool($_item->ship_alone),
                'is_taxable' => Utils::dbBool($_item->taxable),
                'is_virtual' => Utils::dbBool($_item->virtual),
                'track_inventory' => Utils::dbBool($_item->track_inventory)
            ];

            $itemId = $this->saveRecord('items', $item);

            foreach ($_item->skus as $_sku) {
                $skuId = Utils::arrayValue(
                    $this->records['skus'], $_sku->skucode
                );

                $sku = [
                    'sku_id' => $skuId,
                    'updated_at' => Utils::dbDate(),
                    'updated_by' => self::AUTHOR,
                    'division' => $this->division,
                    'status_id' => Status::ITEM_AVAILABLE,
                    'item_id' => $itemId,
                    'skucode' => $_sku->skucode,
                    'barcode' => $_sku->barcode,
                    'cost_price' => $_sku->cost_price,
                    'retail_price' => $_sku->retail_price,
                    'pick_description' => $_sku->pick_description
                ];

                $this->saveRecord('skus', $sku);
            }
        }

        return true;
    }

    protected function init()
    {
        $this->config = [
            'vendors' => [
                'record_name' => 'Vendor',
                'unique_key' => 'vendor_num',
                'primary_key' => 'vendor_id',
                'table_name' => 'vendor',
                'sequence' => 'vendor_vendor_id_seq',
                'author' => self::AUTHOR,
                'constraints' => new Assert\Collection([
                    'allowExtraFields' => true,
                    'fields' => [
                        'vendor_num' => [
                            new Assert\NotBlank,
                            new Assert\Length([
                                'max' => 24
                            ])
                        ],
                        'display_name' => new Assert\NotBlank,
                        'primary_contact' => new Assert\NotBlank,
                        'email_address' => new Assert\Email
                    ]
                ])
            ],
            'items' => [
                'record_name' => 'Item',
                'unique_key' => 'item_num',
                'primary_key' => 'item_id',
                'table_name' => 'item',
                'sequence' => 'item_item_id_seq',
                'author' => self::AUTHOR,
                'constraints' => new Assert\Collection([
                    'allowExtraFields' => true,
                    'fields' => [
                        'item_num' => new Assert\NotBlank,
                        'display_name' => new Assert\NotBlank
                    ]
                ])
            ],
            'skus' => [
                'record_name' => 'SKU',
                'unique_key' => 'skucode',
                'primary_key' => 'sku_id',
                'table_name' => 'item_sku',
                'sequence' => 'item_sku_sku_id_seq',
                'author' => self::AUTHOR,
                'constraints' => new Assert\Collection([
                    'allowExtraFields' => true,
                    'fields' => [
                        'skucode' => new Assert\NotBlank,
                        'barcode' => new Assert\NotBlank,
                        'pick_description' => new Assert\NotBlank
                    ]
                ])
            ]
        ];

        return true;
    }

}
