<?php

namespace Orderware\AppBundle\Tests\Library;

use Orderware\AppBundle\Library\Utils;

class UtilsTest extends \PHPUnit_Framework_TestCase
{

    public function testGettingArrayValueReturnsNullByDefault()
    {
        $this->assertNull(Utils::arrayValue([], 'key'));
    }

    public function testGettingArrayValueRequiresScalarKey()
    {
        $this->assertNull(Utils::arrayValue(['key' => 'a'], new \StdClass));
    }

    public function testGettingArrayValue()
    {
        $this->assertEquals('a', Utils::arrayValue(['key' => 'a'], 'key'));
    }

    public function testGettingDatabaseBooleanValue()
    {
        $this->assertEquals('f', Utils::dbBool(false));
        $this->assertEquals('t', Utils::dbBool(true));
    }

    public function testGettingDatabaseDate()
    {
        $this->assertEquals(date('Y-m-d H:i:s'), Utils::dbDate());
    }

    /**
     * @group FragileTests
     */
    public function testGeneratingRandomString()
    {
        $this->assertNotEquals(
            Utils::randomString(16),
            Utils::randomString(16)
        );
    }

}