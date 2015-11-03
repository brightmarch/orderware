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

    public function testSettingPickDescriptionIsUppercased()
    {
        $sku = new ItemSku;
        $sku->setPickDescription('sumatra coffee');

        $this->assertEquals('SUMATRA COFFEE', $sku->getPickDescription());
    }

}
