<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\OrdImport;
use Orderware\AppBundle\Library\Status;

class OrdImportTest extends \PHPUnit_Framework_TestCase
{

    public function testSettingOrderNumIsUppercased()
    {
        $import = new OrdImport;
        $import->setOrderNum('ord123');

        $this->assertEquals('ORD123', $import->getOrderNum());
    }

    public function testHasErrorCalculatedOnUpdate()
    {
        $import = new OrdImport;
        $this->assertFalse($import->hasError());

        $import->onUpdate();
        $this->assertFalse($import->hasError());

        $import->setErrorMessage('fatal error');
        $import->onUpdate();

        $this->assertTrue($import->hasError());
    }

    public function testIsEnqueued()
    {
        $import = new OrdImport;
        $this->assertFalse($import->isEnqueued());

        $import->setStatusId(Status::ORDER_IMPORT_ENQUEUED);
        $this->assertTrue($import->isEnqueued());
    }

    public function testIsProcessing()
    {
        $import = new OrdImport;
        $this->assertFalse($import->isProcessing());

        $import->setStatusId(Status::ORDER_IMPORT_PROCESSING);
        $this->assertTrue($import->isProcessing());
    }

    public function testIsProcessed()
    {
        $import = new OrdImport;
        $this->assertFalse($import->isProcessed());

        $import->setStatusId(Status::ORDER_IMPORT_PROCESSED);
        $this->assertTrue($import->isProcessed());
    }

}
