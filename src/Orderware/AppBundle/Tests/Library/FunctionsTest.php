<?php

namespace Orderware\AppBundle\Tests\Library;

use Orderware\AppBundle\Library\Functions;

class FunctionsTest extends \PHPUnit_Framework_TestCase
{

    public function testGettingArrayValueReturnsNullByDefault()
    {
        $this->assertNull(Functions::arrayValue([], 'key'));
    }

    public function testGettingArrayValueRequiresScalarKey()
    {
        $this->assertNull(Functions::arrayValue(['key' => 'a'], new \StdClass));
    }

    public function testGettingArrayValue()
    {
        $this->assertEquals('a', Functions::arrayValue(['key' => 'a'], 'key'));
    }

    public function testGettingDatabaseBooleanValue()
    {
        $this->assertEquals('f', Functions::dbBool(false));
        $this->assertEquals('t', Functions::dbBool(true));
    }

    public function testGettingDatabaseDate()
    {
        $this->assertEquals(date('Y-m-d H:i:s'), Functions::dbDate());
    }

    /**
     * @group FragileTests
     */
    public function testGeneratingRandomString()
    {
        $this->assertNotEquals(
            Functions::randomString(16),
            Functions::randomString(16)
        );
    }

}
