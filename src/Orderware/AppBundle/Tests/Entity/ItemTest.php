<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\Item;
use Orderware\AppBundle\Entity\ItemSku;

class ItemTest extends \PHPUnit_Framework_TestCase
{

    public function testToString()
    {
        $item = new Item;
        $this->assertEquals('Item (null)', $item->__toString());

        $item->setItemNum('0000001');
        $this->assertEquals('Item (0000001)', $item->__toString());
    }

    public function testSettingItemNumIsUppercased()
    {
        $item = new Item;
        $item->setItemNum('g10001d');

        $this->assertEquals('G10001D', $item->getItemNum());
    }

    public function testItemIsInitiallyInactive()
    {
        $item = new Item;

        $this->assertFalse($item->isActive());
    }

    public function testSettingStatusDeterminesStatusId()
    {
        $item = new Item;
        $this->assertFalse($item->isActive());

        $item->setStatus('INVALID');
        $this->assertFalse($item->isActive());

        $item->setStatus('ACTIVE');
        $this->assertTrue($item->isActive());

        $item->setStatus('inactive');
        $this->assertFalse($item->isActive());

        $item->setStatus('active');
        $this->assertTrue($item->isActive());
    }

    public function testDeactivatingItemDeactivatesAllChildSkus()
    {
        $sku1 = new ItemSku;
        $sku1->setStatus('ACTIVE');

        $sku2 = new ItemSku;
        $sku2->setStatus('ACTIVE');

        $this->assertTrue($sku1->isActive());
        $this->assertTrue($sku2->isActive());

        $item = new Item;
        $item->setStatus('ACTIVE');

        $item->addSku($sku1);
        $item->addSku($sku2);

        $item->setStatus('INACTIVE');

        $this->assertFalse($item->isActive());
        $this->assertFalse($sku1->isActive());
        $this->assertFalse($sku2->isActive());
    }

    public function testIsShipAlone()
    {
        $item = new Item;
        $this->assertFalse($item->isShipAlone());

        $item->setIsShipAlone(true);
        $this->assertTrue($item->isShipAlone());
    }

    public function testIsVirtual()
    {
        $item = new Item;
        $this->assertFalse($item->isVirtual());

        $item->setIsVirtual(true);
        $this->assertTrue($item->isVirtual());
    }

    public function testShouldTrackInventory()
    {
        $item = new Item;
        $this->assertTrue($item->shouldTrackInventory());

        $item->setTrackInventory(false);
        $this->assertFalse($item->shouldTrackInventory());
    }

}
