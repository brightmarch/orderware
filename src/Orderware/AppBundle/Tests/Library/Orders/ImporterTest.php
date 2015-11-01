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

        // These come from the sample JSON.
        $orderedAt = '2015-08-03 02:55:00';
        $orderDate = '2015-08-02';

        $import = $this->fixtures['ord_import'];
        $import->setOrderBody($orderBody);

        $this->getContainer()
            ->get('orderware.order_importer')
            ->import($import);

        $order = $this->loadOrder($import->getOrdId());

        $this->assertEquals($orderedAt, $order['ordered_at']);
        $this->assertEquals($orderDate, $order['order_date']);
    }

    private function loadOrder($ordId)
    {
        $sql = "
            SELECT oh.* FROM ord_header oh
            WHERE oh.ord_id = ?
        ";

        $order = $this->getContainer()
            ->get('doctrine')
            ->getManager('orderware')
            ->getConnection()
            ->fetchAssoc($sql, [$ordId]);

        return $order;
    }

}
