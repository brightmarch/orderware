<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\Division;
use Orderware\AppBundle\Library\Status;

class DivisionTest extends \PHPUnit_Framework_TestCase
{

    public function testToString()
    {
        $division = new Division;
        $division->setDivision('GROWERS');

        $this->assertEquals('GROWERS', $division->__toString());
    }

    public function testSettingDivisionIsUppercased()
    {
        $division = new Division;
        $division->setDivision('growers');

        $this->assertEquals('GROWERS', $division->getDivision());
    }

    public function testDivisionIsInitiallyDisabled()
    {
        $division = new Division;

        $this->assertSame(Status::DISABLED, $division->getStatusId());
    }

    public function testSettingCurrencyIsUppercased()
    {
        $division = new Division;
        $division->setCurrency('usd');

        $this->assertEquals('USD', $division->getCurrency());
    }

    public function testSettingEmailContactsAreLowercased()
    {
        $division = new Division;
        $division->setPrimaryEmail('PRIMARY@growerscoffee.com');
        $division->setNotificationEmail('SAYHI@growerscoffee.com');

        $this->assertEquals('primary@growerscoffee.com', $division->getPrimaryEmail());
        $this->assertEquals('sayhi@growerscoffee.com', $division->getNotificationEmail());
    }

    public function testIsEnabled()
    {
        $division = new Division;
        $this->assertFalse($division->isEnabled());

        $division->setStatusId(Status::ENABLED);
        $this->assertTrue($division->isEnabled());
    }

}
