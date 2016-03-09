<?php

namespace Orderware\AppBundle\Command;

use Orderware\AppBundle\Entity\Item;
use Orderware\AppBundle\Entity\ItemSku;
use Orderware\AppBundle\Entity\ItemSkuBarcode;
use Orderware\AppBundle\Entity\Vendor;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;

use \DOMDocument;

use \InvalidArgumentException,
    \RuntimeException;

class ImportProductsCommand extends ContainerAwareCommand
{

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $_em = $this->getContainer()
            ->get('doctrine')
            ->getManager('orderware');

        $divisionName = $input->getArgument('division');

        // Ensure the division actually exists.
        $division = $_em->getRepository('Orderware:Division')
            ->findOneByDivision($divisionName);

        if (!$division) {
            throw new InvalidArgumentException(sprintf("The division (%s) does not exist.", $divisionName));
        }

        // Ensure the division is enabled.
        if (!$division->isEnabled()) {
            throw new RuntimeException(sprintf("The division (%s) is not enabled.", $divisionName));
        }

        // Find the FeedConfig record and ensure this division is enabled to handle this feed.
        // Validate the feed against the schema (ensure the feed version matches the config version).
        // Bootstrap a new feed service to process the feed.
        // 

        #$validator = $this->getContainer()
        #    ->get('validator');

        #$feedFile = $input->getArgument('feed-file');

        #$this->getContainer()
        #    ->get('orderware.feed_validator')
        #    ->validate('item', '1.0.0', $feedFile);

        /*
        $validator = $this->getContainer()
            ->get('validator');

        // Convert the DOM to a SimpleXML object
        // because they are much easier to work with.
        $xml = simplexml_import_dom($dom);

        foreach ($xml->Vendors->Vendor as $recordType => $_vend) {
            $vendorNum = (string)$_vend->Number;

            $vendor = $_em->getRepository('Orderware:Vendor')
                ->findOneBy([
                    'division' => $division,
                    'vendorNum' => $vendorNum
                ]);

            if (!$vendor) {
                $vendor = new Vendor;
                $vendor->setDivision($division)
                    ->setCreatedBy('product_importer')
                    ->setVendorNum($vendorNum);
            }

            $vendor->setUpdatedBy('product_importer')
                ->setDisplayName((string)$_vend->DisplayName)
                ->setPrimaryContact((string)$_vend->PrimaryContact)
                ->setAddress1((string)$_vend->Address1)
                ->setAddress2((string)$_vend->Address2)
                ->setCityName((string)$_vend->CityName)
                ->setPostalCode((string)$_vend->PostalCode)
                ->setStateCode((string)$_vend->StateCode)
                ->setStateName((string)$_vend->StateName)
                ->setCountryCode((string)$_vend->CountryCode)
                ->setCountryName((string)$_vend->CountryName)
                ->setEmailAddress((string)$_vend->EmailAddress)
                ->setPhoneNumber((string)$_vend->PhoneNumber)
                ->setFaxNumber((string)$_vend->FaxNumber)
                ->setNotes((string)$_vend->Notes);

            // Validate the entity. Report any errors and stop processing.
            $errors = $validator->validate($vendor);

            if ($errors->count() > 0) {
                throw new RuntimeException(sprintf("Invalid %s(%s).%s: %s", $recordType, $vendorNum, $errors[0]->getPropertyPath(), $errors[0]->getMessage()));
            }

            $_em->persist($vendor);
        }

        $_em->flush();

        foreach ($xml->Items->Item as $recordType => $_item) {
            $itemNum = (string)$_item->Number;

            $item = $_em->getRepository('Orderware:Item')
                ->findOneBy([
                    'division' => $division,
                    'itemNum' => $itemNum
                ]);

            if (!$item) {
                $item = new Item;
                $item->setDivision($division)
                    ->setCreatedBy('product_importer')
                    ->setItemNum($itemNum);
            }

            $item->setUpdatedBy('product_importer')
                ->setDisplayName((string)$_item->DisplayName)
                ->setWeight((float)$_item->Weight)
                ->setLength((float)$_item->Length)
                ->setWidth((float)$_item->Width)
                ->setDepth((float)$_item->Depth)
                ->setIsShipAlone((bool)$_item->ShipAlone)
                ->setIsTaxable((bool)$_item->Taxable)
                ->setIsVirtual((bool)$_item->Virtual);

            foreach ($_item->Skus->Sku as $_sku) {
                $skucode = (string)$_sku->Skucode;
                $vendorNum = (string)$_sku->VendorNumber;

                $sku = $_em->getRepository('Orderware:ItemSku')
                    ->findOneBy([
                        'division' => $division,
                        'skucode' => $skucode
                    ]);

                $vendor = $_em->getRepository('Orderware:Vendor')
                    ->findOneBy([
                        'division' => $division,
                        'vendorNum' => $vendorNum
                    ]);

                if (!$sku) {
                    $sku = new ItemSku;
                    $sku->setDivision($division)
                        ->setItem($item)
                        ->setCreatedBy('product_importer')
                        ->setSkucode($skucode);
                }

                $sku->setVendor($vendor)
                    ->setUpdatedBy('product_importer')
                    ->setCostPrice((int)$_sku->CostPrice)
                    ->setRetailPrice((int)$_sku->RetailPrice)
                    ->setPickDescription((string)$_sku->PickDescription);

                foreach ($_sku->Barcodes->Barcode as $_barcode) {
                    $barcode = $_em->getRepository('Orderware:ItemSkuBarcode')
                        ->findOneBy([
                            'division' => $division,
                            'barcode' => (string)$_barcode
                        ]);

                    if (!$barcode) {
                        $barcode = new ItemSkuBarcode;
                        $barcode->setDivision($division)
                            ->setSku($sku)
                            ->setCreatedBy('product_importer')
                            ->setBarcode((string)$_barcode);
                    }

                    $barcode->setUpdatedBy('product_importer');
                    $sku->addBarcode($barcode);
                }

                $item->addSku($sku);
            }

            $errors = $validator->validate($item);

            if ($errors->count() > 0) {
                throw new RuntimeException(sprintf("Invalid %s(%s).%s: %s", $recordType, $itemNum, $errors[0]->getPropertyPath(), $errors[0]->getMessage()));
            }

            // Set the status here so if the item is disabled
            // it will cascade to all of the individual SKUs.
            $item->setStatus((string)$_item->Status);

            $_em->persist($item);
        }

        try {
            $_em->flush();
        } catch (\Doctrine\DBAL\DBALException $e) {
            echo($e->getPrevious()->getPrevious()->getMessage() . "\n\n");
        }
        */

        return 0;
    }

    public function configure()
    {
        $this->setName('orderware:import-products')
            ->addArgument('division', InputArgument::REQUIRED)
            ->addArgument('feed-file', InputArgument::REQUIRED, "Full path to feed file")
            ->setDescription("Imports a product feed for a specific division.");

        return true;
    }

}
