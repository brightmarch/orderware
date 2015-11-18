<?php

namespace Orderware\AppBundle\Library\Feeds;

use Orderware\AppBundle\Entity\Item;
use Orderware\AppBundle\Entity\ItemSku;
use Orderware\AppBundle\Entity\Vendor;
use Orderware\AppBundle\Library\Feeds\AbstractProcessor;
use Orderware\AppBundle\Library\Status;

class ProductProcessor extends AbstractProcessor
{

    /** @const string */
    const AUTHOR = 'product_processor';

    protected function process()
    {
        foreach ($this->feedBody->vendors as $_vend) {
            $vendor = $this->entityManager
                ->getRepository('Orderware:Vendor')
                ->findOneBy([
                    'division' => $this->division,
                    'vendorNum' => $_vend->vendor_num
                ]);

            if (!$vendor) {
                $vendor = new Vendor;
                $vendor->setDivision($this->division)
                    ->setCreatedBy(self::AUTHOR)
                    ->setVendorNum($_vend->vendor_num);
            }

            $vendor->setUpdatedBy(self::AUTHOR)
                ->setDisplayName($_vend->display_name)
                ->setPrimaryContact($_vend->primary_contact)
                ->setAddress1($_vend->address1)
                ->setAddress2($_vend->address2)
                ->setCityName($_vend->city_name)
                ->setPostalCode($_vend->postal_code)
                ->setStateCode($_vend->state_code)
                ->setStateName($_vend->state_name)
                ->setCountryCode($_vend->country_code)
                ->setCountryName($_vend->country_name)
                ->setPhoneNumber($_vend->phone_number)
                ->setEmailAddress($_vend->email_address)
                ->setFaxNumber($_vend->fax_number);

            $this->saveRecord($vendor);
        }

        foreach ($this->feedBody->items as $_item) {
            $item = $this->entityManager
                ->getRepository('Orderware:Item')
                ->findOneBy([
                    'division' => $this->division,
                    'itemNum' => $_item->item_num
                ]);

            if (!$item) {
                $item = new Item;
                $item->setDivision($this->division)
                    ->setCreatedBy(self::AUTHOR)
                    ->setItemNum($_item->item_num);
            }

            $item->setUpdatedBy(self::AUTHOR)
                ->setStatusId(Status::ITEM_AVAILABLE)
                ->setDisplayName($_item->display_name)
                ->setWeight($_item->weight)
                ->setLength($_item->length)
                ->setWidth($_item->width)
                ->setDepth($_item->depth)
                ->setIsShipAlone($_item->ship_alone)
                ->setIsTaxable($_item->taxable)
                ->setIsVirtual($_item->virtual)
                ->setTrackInventory($_item->track_inventory);

            $this->saveRecord($item);

            foreach ($_item->skus as $_sku) {
                $itemSku = $this->entityManager
                    ->getRepository('Orderware:ItemSku')
                    ->findOneBy([
                        'division' => $this->division,
                        'skucode' => $_sku->skucode
                    ]);

                if (!$itemSku) {
                    $itemSku = new ItemSku;
                    $itemSku->setDivision($this->division)
                        ->setItem($item)
                        ->setCreatedBy(self::AUTHOR)
                        ->setSkucode($_sku->skucode);
                }

                $itemSku->setUpdatedBy(self::AUTHOR)
                    ->setStatusId(Status::ITEM_AVAILABLE)
                    ->setBarcode($_sku->barcode)
                    ->setCostPrice($_sku->cost_price)
                    ->setRetailPrice($_sku->retail_price)
                    ->setPickDescription($_sku->pick_description);

                $this->saveRecord($itemSku);
            }
        }

        $this->entityManager
            ->flush();

        return true;
    }

}
