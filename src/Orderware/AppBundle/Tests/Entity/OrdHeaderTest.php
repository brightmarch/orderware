<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\OrdHeader;
use Orderware\AppBundle\Entity\OrdLine;
use Orderware\AppBundle\Entity\OrdLock;

class OrdHeaderTest extends \PHPUnit_Framework_TestCase
{

    public function testSettingOrderNumIsUppercased()
    {
        $order = new OrdHeader;
        $order->setOrderNum('ord123');

        $this->assertEquals('ORD123', $order->getOrderNum());
    }

    public function testSettingCurrencyIsUppercased()
    {
        $order = new OrdHeader;
        $order->setCurrency('usd');

        $this->assertEquals('USD', $order->getCurrency());
    }

    public function testHasUniqueLineNumbers()
    {
        $order = new OrdHeader;
        $this->assertTrue($order->hasUniqueLineNumbers());

        $line1 = new OrdLine;
        $line1->setLineNum('1');
        $order->addLine($line1);
        $this->assertTrue($order->hasUniqueLineNumbers());

        $line2 = new OrdLine;
        $line2->setLineNum('2');
        $order->addLine($line2);
        $this->assertTrue($order->hasUniqueLineNumbers());

        $line3 = new OrdLine;
        $line3->setLineNum('2');
        $order->addLine($line3);
        $this->assertFalse($order->hasUniqueLineNumbers());
    }

    public function testIsLocked()
    {
        $order = new OrdHeader;
        $this->assertFalse($order->isLocked());

        $lock1 = new OrdLock;
        $order->addLock($lock1);
        $this->assertTrue($order->isLocked());

        $lock1->setRemovedAt(date_create());
        $this->assertFalse($order->isLocked());
    }

    public function testCalculatingLineAmounts()
    {
        $order = new OrdHeader;

        $order->calculate();
        $this->assertEquals(0.0, $order->getLineAmount());

        $order->setShippingAmount(599);
        $order->setShippingLocalTaxAmount(11);
        $order->setShippingCountyTaxAmount(35);
        $order->setShippingStateTaxAmount(19);

        $line1 = new OrdLine;
        $line1->setQtyOrdered(2);
        $line1->setRetailAmount(1025);
        $line1->setLocalTaxAmount(14);
        $line1->setCountyTaxAmount(28);
        $line1->setStateTaxAmount(89);
        $order->addLine($line1);

        $line2 = new OrdLine;
        $line2->setQtyOrdered(3);
        $line2->setQtyCanceled(1);
        $line2->setRetailAmount(799);
        $line2->setDiscountAmount(122);
        $order->addLine($line2);

        $order->calculate();
        $this->assertEquals(3648, $order->getLineAmount());
        $this->assertEquals(244, $order->getDiscountAmount());
        $this->assertEquals(262, $order->getLineTaxAmount());
        $this->assertEquals(28, $order->getLineLocalTaxAmount());
        $this->assertEquals(56, $order->getLineCountyTaxAmount());
        $this->assertEquals(178, $order->getLineStateTaxAmount());
        $this->assertEquals(4330, $order->getOrderAmount());
    }

    public function testCalculatingShippingTaxAmounts()
    {
        $order = new OrdHeader;

        $order->calculate();
        $this->assertEquals(0.0, $order->getShippingTaxAmount());

        $order->setShippingLocalTaxAmount(11);
        $order->setShippingCountyTaxAmount(35);
        $order->setShippingStateTaxAmount(19);

        $order->calculate();
        $this->assertEquals(65, $order->getShippingTaxAmount());
    }

}
