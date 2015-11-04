<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\OrdLock;

class OrdLockTest extends \PHPUnit_Framework_TestCase
{

    public function testIsActive()
    {
        $lock = new OrdLock;
        $this->assertTrue($lock->isActive());

        $lock->setRemovedAt(date_create());
        $this->assertFalse($lock->isActive());
    }

}
