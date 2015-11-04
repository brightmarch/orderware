<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\OrdHeader;

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

}
