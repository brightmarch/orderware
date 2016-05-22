<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\FeedLogFile;

class FeedLogFileTest extends \PHPUnit_Framework_TestCase
{

    public function testSettingContentsCalculatesFileSize()
    {
        $contents = '<xml><items></xml>';

        $feedLogFile = new FeedLogFile;
        $this->assertNull($feedLogFile->getContents());
        $this->assertEquals(0, $feedLogFile->getFileSize());

        $feedLogFile->setContents($contents);

        $this->assertEquals($contents, $feedLogFile->getContents());
        $this->assertEquals(18, $feedLogFile->getFileSize());
    }

}
