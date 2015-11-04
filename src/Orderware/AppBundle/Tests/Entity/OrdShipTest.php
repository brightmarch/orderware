<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\OrdShip;

class OrdShipTest extends \PHPUnit_Framework_TestCase
{

    public function testSettingShipMethodIsUppercased()
    {
        $shipment = new OrdShip;
        $shipment->setShipMethod('1da');

        $this->assertEquals('1DA', $shipment->getShipMethod());
    }

    public function testSettingStateCodeIsUppercased()
    {
        $shipment = new OrdShip;
        $shipment->setStateCode('tx');

        $this->assertEquals('TX', $shipment->getStateCode());
    }

    public function testSettingCountryCodeIsUppercased()
    {
        $shipment = new OrdShip;
        $shipment->setCountryCode('us');

        $this->assertEquals('US', $shipment->getCountryCode());
    }

    public function testSettingEmailAddressIsLowercased()
    {
        $shipment = new OrdShip;
        $shipment->setEmailAddress('VIC@GROWERScoffee.com');

        $this->assertEquals('vic@growerscoffee.com', $shipment->getEmailAddress());
    }

    public function testSettingNotifyByIsLowercased()
    {
        $shipment = new OrdShip;
        $shipment->setNotifyBy('EMAIL');

        $this->assertEquals('email', $shipment->getNotifyBy());
    }

    public function testSettingFacilityCodeIsUppercased()
    {
        $shipment = new OrdShip;
        $shipment->setFacilityCode('growers01');

        $this->assertEquals('GROWERS01', $shipment->getFacilityCode());
    }

    public function testHasFacilityCode()
    {
        $shipment = new OrdShip;
        $this->assertFalse($shipment->hasFacilityCode());

        $shipment->setFacilityCode('GROWERS02');
        $this->assertTrue($shipment->hasFacilityCode());
    }

}
