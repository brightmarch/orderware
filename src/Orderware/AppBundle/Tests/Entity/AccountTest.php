<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\Account;
use Orderware\AppBundle\Library\Status;

class AccountTest extends \PHPUnit_Framework_TestCase
{

    public function testToString()
    {
        $account = new Account;
        $account->setAccount('GROWERS');

        $this->assertEquals('GROWERS', $account->__toString());
    }

    public function testSettingAccountIsUppercased()
    {
        $account = new Account;
        $account->setAccount('growers');

        $this->assertEquals('GROWERS', $account->getAccount());
    }

    public function testAccountIsInitiallyDisabled()
    {
        $account = new Account;

        $this->assertFalse($account->isEnabled());
    }

    public function testSettingCurrencyIsUppercased()
    {
        $account = new Account;
        $account->setCurrency('usd');

        $this->assertEquals('USD', $account->getCurrency());
    }

    public function testSettingEmailContactsAreLowercased()
    {
        $account = new Account;
        $account->setPrimaryEmail('PRIMARY@growerscoffee.com');
        $account->setNotificationEmail('SAYHI@growerscoffee.com');

        $this->assertEquals('primary@growerscoffee.com', $account->getPrimaryEmail());
        $this->assertEquals('sayhi@growerscoffee.com', $account->getNotificationEmail());
    }

    public function testIsEnabled()
    {
        $account = new Account;
        $this->assertFalse($account->isEnabled());

        $account->setStatusId(Status::ENABLED);
        $this->assertTrue($account->isEnabled());
    }

}
