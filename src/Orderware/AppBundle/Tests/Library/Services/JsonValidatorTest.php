<?php

namespace Orderware\AppBundle\Tests\Library\Services;

use Orderware\AppBundle\Tests\TestCase;

class JsonValidatorTest extends TestCase
{

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage The schema (invalid) could not be found.
     */
    public function testValidatingJsonRequiresValidSchema()
    {
        $this->getContainer()
            ->get('orderware.json_validator')
            ->validate('invalid', null);
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage The JSON provided is invalid (NULL value found, but an object is required).
     */
    public function testValidatingJsonRequestRequiresValidData()
    {
        $this->getContainer()
            ->get('orderware.json_validator')
            ->validate('feed', '{json}');
    }

    public function testValidatingJson()
    {
        $jsonPayload = file_get_contents(__DIR__ . '/feed_manifest.json');

        $isValid = $this->getContainer()
            ->get('orderware.json_validator')
            ->validate('feed', $jsonPayload);

        $this->assertTrue($isValid);
    }

}
