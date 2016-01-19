<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\ItemSku;

class ItemSkuTest extends \PHPUnit_Framework_TestCase
{

    public function testToString()
    {
        $sku = new ItemSku;
        $this->assertEquals('SKU (null)', $sku->__toString());

        $sku->setSkucode('0000001');
        $this->assertEquals('SKU (0000001)', $sku->__toString());
    }

    public function testItemIsInitiallyInactive()
    {
        $sku = new ItemSku;

        $this->assertFalse($sku->isActive());
    }

    public function testSettingPickDescriptionIsUppercased()
    {
        $sku = new ItemSku;
        $sku->setPickDescription('sumatra coffee');

        $this->assertEquals('SUMATRA COFFEE', $sku->getPickDescription());
    }

    public function testSettingStatusDeterminesStatusId()
    {
        $sku = new ItemSku;
        $this->assertFalse($sku->isActive());

        $sku->setStatus('INVALID');
        $this->assertFalse($sku->isActive());

        $sku->setStatus('ACTIVE');
        $this->assertTrue($sku->isActive());

        $sku->setStatus('inactive');
        $this->assertFalse($sku->isActive());

        $sku->setStatus('active');
        $this->assertTrue($sku->isActive());
    }

}
