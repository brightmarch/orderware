<?php

namespace Orderware\AppBundle\Tests\Library\Orders;

use Orderware\AppBundle\Library\Utils;
use Orderware\AppBundle\Tests\TestCase;

class ImporterTest extends TestCase
{

    public function testImportingOrderRequiresValidJson()
    {
        $import = $this->fixtures['ord_import'];

        $this->getContainer()
            ->get('orderware.order_importer')
            ->import($import);

        $this->assertNull($import->getOrdId());
        $this->assertTrue($import->hasError());
        $this->assertEquals("The order JSON failed to parse correctly.", $import->getErrorMessage());
    }

    public function testOrderDatesAreCalculatedCorrectly()
    {
        $orderBody = file_get_contents(__DIR__ . '/order.no_lines.json');
        $orderJson = json_decode($orderBody);

        // These come from the sample JSON.
        $orderedAt = '2015-08-03 02:55:00';
        $orderDate = '2015-08-02';

        $import = $this->fixtures['ord_import'];
        $import->setOrderBody($orderBody);

        $this->getContainer()
            ->get('orderware.order_importer')
            ->import($import);

        $order = $this->getContainer()
            ->get('orderware.order_loader')
            ->load($orderJson->division, $orderJson->order_num);

        $this->assertEquals($orderedAt, $order['ordered_at']);
        $this->assertEquals($orderDate, $order['order_date']);
    }

    public function testOrderNumMustBeUnique()
    {
        $orderBody = file_get_contents(__DIR__ . '/order.no_lines.json');
        
        $import = $this->fixtures['ord_import'];
        $import->setOrderBody($orderBody);

        $importer = $this->getContainer()
            ->get('orderware.order_importer');

        $importer->import($import);

        $this->assertFalse($import->hasError());
        $this->assertNull($import->getErrorMessage());

        $importer->import($import);

        $this->assertTrue($import->hasError());
        $this->assertEquals("The order number (GROW0000001) already exists.", $import->getErrorMessage());
    }

    public function testOrderNumMustBeAlphaNumeric()
    {
        $orderBody = file_get_contents(__DIR__ . '/order.utf8_order_num.json');

        $import = $this->fixtures['ord_import'];
        $import->setOrderBody($orderBody);

        $importer = $this->getContainer()
            ->get('orderware.order_importer')
            ->import($import);

        $this->assertTrue($import->hasError());
        $this->assertEquals("The order number (Производители0000001) must be alpha-numeric.", $import->getErrorMessage());
    }

    public function _testLineNumbersMustBeUnique()
    {
        $orderBody = file_get_contents(__DIR__ . '/order.duplicate_line_num.json');

    }

    public function testSkuMustExist()
    {
        $orderBody = file_get_contents(__DIR__ . '/order.missing_sku.json');

        $import = $this->fixtures['ord_import'];
        $import->setOrderBody($orderBody);

        $importer = $this->getContainer()
            ->get('orderware.order_importer')
            ->import($import);

        $this->assertTrue($import->hasError());
        $this->assertEquals("The SKU (~) could not be found.", $import->getErrorMessage());
    }

}