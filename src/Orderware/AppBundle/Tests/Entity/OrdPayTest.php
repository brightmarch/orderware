<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\OrdPay;

class OrdPayTest extends \PHPUnit_Framework_TestCase
{

    public function testSettingPayMethodIsUppercased()
    {
        $payment = new OrdPay;
        $payment->setPayMethod('stripe');

        $this->assertEquals('STRIPE', $payment->getPayMethod());
    }

    public function testSettingCurrencyIsUppercased()
    {
        $payment = new OrdPay;
        $payment->setCurrency('usd');

        $this->assertEquals('USD', $payment->getCurrency());
    }

}
