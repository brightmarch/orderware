<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\FeedLog;

class FeedLogTest extends \PHPUnit_Framework_TestCase
{

    public function testCreatingFile()
    {
        $fileName = 'growers_product_catalog.xml';
        $contents = '<xml><items></xml>';

        $feedLog = new FeedLog;
        $this->assertCount(0, $feedLog->getFiles());

        $feedLog->createFile($fileName, $contents);
        $feedFile = $feedLog->getFiles()->first();

        $this->assertEquals($contents, $feedFile->getContents());
    }

    public function testLoggingEntry()
    {
        $feedLog = new FeedLog;
        $this->assertCount(0, $feedLog->getEntries());

        $feedLog->logEntry("Found 1000 SKUs to process.", false);
        $this->assertCount(1, $feedLog->getEntries());

        $feedLog->logEntry("Invalid record #2.", true);
        $this->assertCount(2, $feedLog->getEntries());
    }

    public function testLoggingErrorBubblesErrorToFeedLog()
    {
        $feedLog = new FeedLog;
        $this->assertFalse($feedLog->hasError());
        $this->assertNull($feedLog->getErrorMessage());

        $feedLog->logEntry("Error #1", true);
        $this->assertTrue($feedLog->hasError());
        $this->assertEquals("Error #1", $feedLog->getErrorMessage());

        $feedLog->logEntry("Success #1", false);
        $this->assertTrue($feedLog->hasError());
        $this->assertEquals("Error #1", $feedLog->getErrorMessage());

        $feedLog->logEntry("Error #2", true);
        $this->assertTrue($feedLog->hasError());
        $this->assertEquals("Error #2", $feedLog->getErrorMessage());

        $this->assertCount(3, $feedLog->getEntries());
    }

}
