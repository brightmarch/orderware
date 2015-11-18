<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\Item;
use Orderware\AppBundle\Entity\OrdLine;

class OrdLineTest extends \PHPUnit_Framework_TestCase
{

    public function testSettingPickDescriptionIsUppercased()
    {
        $line = new OrdLine;
        $line->setPickDescription('sumatra coffee');

        $this->assertEquals('SUMATRA COFFEE', $line->getPickDescription());
    }

    public function testGettingLineAmountIsInitiallyZero()
    {
        $line = new OrdLine;
        $this->assertEquals(0, $line->getLineAmount());
    }

    public function testGettingLineAmountRequiresAvailableQty()
    {
        $line = new OrdLine;
        $line->setRetailAmount(1000);
        $line->calculate();

        $this->assertEquals(0, $line->getLineAmount());
    }

    public function testGettingLineAmountRequiresPricingAmounts()
    {
        $line = new OrdLine;
        $line->setQtyOrdered(1);
        $line->calculate();

        $this->assertEquals(0, $line->getLineAmount());
    }

    public function testGettingLineAmount()
    {
        $line = new OrdLine;
        $line->setQtyAvailable(3);

        $line->setRetailAmount(1025);
        $line->setDiscountAmount(149);
        $line->setTaxAmount(79);

        $this->assertEquals(2865, $line->getLineAmount());
    }

    public function testTaxCalculation()
    {
        $line = new OrdLine;

        $line->calculate();
        $this->assertEquals(0, $line->getTaxAmount());

        $line->setLocalTaxAmount(13);
        $line->setCountyTaxAmount(14);
        $line->setStateTaxAmount(15);

        $line->calculate();
        $this->assertEquals(42, $line->getTaxAmount());
    }

    public function testQtyCalculation()
    {
        $line = new OrdLine;

        $line->calculate();
        $this->assertEquals(0, $line->getQtyBackordered());

        $line->setQtyOrdered(10);
        $line->setQtyCanceled(1);
        $line->setQtyAllocated(2);
        $line->setQtyPicked(3);
        $line->setQtyShipped(4);

        $line->calculate();
        $this->assertEquals(0, $line->getQtyBackordered());

        $line->setQtyPicked(0);
        $line->calculate();
        $this->assertEquals(3, $line->getQtyBackordered());
    }

    public function testQtyBackorderedDoesNotUseQtyReturned()
    {
        $line = new OrdLine;

        $line->calculate();
        $this->assertEquals(0, $line->getQtyBackordered());

        $line->setQtyOrdered(5);
        $line->setQtyShipped(3);
        $line->setQtyReturned(3);

        $line->calculate();
        $this->assertEquals(2, $line->getQtyBackordered());
    }

}
