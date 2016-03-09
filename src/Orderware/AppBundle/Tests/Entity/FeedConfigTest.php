<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\FeedConfig;
use Orderware\AppBundle\Library\Status;

class FeedConfigTest extends \PHPUnit_Framework_TestCase
{

    public function testSettingNameIsLowercased()
    {
        $config = new FeedConfig;
        $config->setName('ITEMS');

        $this->assertEquals('items', $config->getName());
    }

    public function testSettingDirectionIsLowercased()
    {
        $config = new FeedConfig;
        $config->setDirection('INBOUND');

        $this->assertEquals('inbound', $config->getDirection());
    }

    public function testSettingServiceIsLowercased()
    {
        $config = new FeedConfig;
        $config->setService('ORDERWARE.ITEM_FEED');

        $this->assertEquals('orderware.item_feed', $config->getService());
    }

    public function testSettingEnvironmentLowercased()
    {
        $config = new FeedConfig;
        $config->setEnvironment('DEV');

        $this->assertEquals('dev', $config->getEnvironment());
    }

}
