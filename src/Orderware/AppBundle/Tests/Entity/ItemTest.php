<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\Item;

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
    }

    public function testSettingStatusIgnoresCase()
    {
        $item = new Item;
        $this->assertFalse($item->isActive());

        $item->setStatus('active');
        $this->assertTrue($item->isActive());
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
