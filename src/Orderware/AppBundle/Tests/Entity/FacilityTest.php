<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\Division;
use Orderware\AppBundle\Entity\Facility;

class FacilityTest extends \PHPUnit_Framework_TestCase
{

    public function testToString()
    {
        $facility = new Facility;
        $this->assertEquals('Facility (null)', $facility->__toString());

        $facility->setFacilityCode('GROWERS01');
        $this->assertEquals('Facility (GROWERS01)', $facility->__toString());
    }

    public function testSettingFacilityCodeIsUppercased()
    {
        $facility = new Facility;
        $facility->setFacilityCode('growers01');

        $this->assertEquals('GROWERS01', $facility->getFacilityCode());
    }

    public function testSettingStateCodeIsUppercased()
    {
        $facility = new Facility;
        $facility->setStateCode('tx');

        $this->assertEquals('TX', $facility->getStateCode());
    }

    public function testSettingCountryCodeIsUppercased()
    {
        $facility = new Facility;
        $facility->setCountryCode('usd');

        $this->assertEquals('USD', $facility->getCountryCode());
    }

    public function testIsMaster()
    {
        $facility = new Facility;
        $this->assertFalse($facility->isMaster());

        $facility->setIsMaster(true);
        $this->assertTrue($facility->isMaster());
    }

}
