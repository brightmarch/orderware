<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\Ledger;

class LedgerTest extends \PHPUnit_Framework_TestCase
{

    public function testSettingLedgerCodeIsUppercased()
    {
        $ledger = new Ledger;
        $ledger->setLedgerCode('la');

        $this->assertEquals('LA', $ledger->getLedgerCode());
    }

}
