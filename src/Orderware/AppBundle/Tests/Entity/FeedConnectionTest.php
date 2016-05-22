<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\FeedConnection;

class FeedConnectionTest extends \PHPUnit_Framework_TestCase
{

    public function testSettingTypeIsLowercased()
    {
        $feedConnection = new FeedConnection;
        $feedConnection->setType('SSH');

        $this->assertEquals('ssh', $feedConnection->getType());
    }

    public function testSettingNameIsLowercased()
    {
        $feedConnection = new FeedConnection;
        $feedConnection->setName('ORDERWARE_SSH');

        $this->assertEquals('orderware_ssh', $feedConnection->getName());
    }

    public function testSettingPortCanNotBeNegative()
    {
        $feedConnection = new FeedConnection;
        $feedConnection->setPort(-22);

        $this->assertEquals(22, $feedConnection->getPort());
    }

    public function testSettingTimeoutCanNotBeNegative()
    {
        $feedConnection = new FeedConnection;
        $feedConnection->setTimeout(-30);

        $this->assertEquals(30, $feedConnection->getTimeout());
    }

}
