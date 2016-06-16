<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\FeedAttribute;

class FeedAttributeTest extends \PHPUnit_Framework_TestCase
{

    public function testSettingKeyIsLowercased()
    {
        $feedAttribute = new FeedAttribute;
        $feedAttribute->setKey('ITEM.FTP_SERVER');

        $this->assertEquals('item.ftp_server', $feedAttribute->getKey());
    }

}
