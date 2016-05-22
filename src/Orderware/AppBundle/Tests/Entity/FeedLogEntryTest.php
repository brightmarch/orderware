<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\FeedLogEntry;

class FeedLogEntryTest extends \PHPUnit_Framework_TestCase
{

    public function testIsError()
    {
        $feedLogEntry = new FeedLogEntry;
        $this->assertFalse($feedLogEntry->isError());

        $feedLogEntry->setIsError(true);
        $this->assertTrue($feedLogEntry->isError());
    }

}
