<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\Division;
use Orderware\AppBundle\Entity\Connection;
use Orderware\AppBundle\Entity\User;
use Orderware\AppBundle\Library\Constants;
use Orderware\AppBundle\Library\Status;

use \ReflectionMethod,
    \ReflectionProperty;

class UserTest extends \PHPUnit_Framework_TestCase
{

    public function testToString()
    {
        $user = new User;
        $user->setUsername('vic@stackbased.com');

        $this->assertEquals('vic@stackbased.com', $user->__toString());
    }

    public function testSettingUsernameIsLowercased()
    {
        $user = new User;
        $user->setUsername('ORDERWARE');

        $this->assertEquals('orderware', $user->getUsername());
    }

    public function testSettingRoleIsUppercased()
    {
        $user = new User;
        $user->setRole('role_administrator');

        $this->assertEquals('ROLE_ADMINISTRATOR', $user->getRole());
    }

    public function testIsEnabled()
    {
        $user = new User;
        $this->assertFalse($user->isEnabled());

        $user->setStatusId(Status::ENABLED);
        $this->assertTrue($user->isEnabled());
    }

    public function testCredentialsCanNotBeErased()
    {
        $username = 'orderware';

        $user = new User;
        $user->setUsername($username);

        $this->assertFalse($user->eraseCredentials());
        $this->assertEquals($username, $user->getUsername());
    }

    public function testSerializingCredentials()
    {
        $userId = mt_rand(1, 100);
        $username = 'orderware';

        $user = new User;
        $user->setUsername($username);

        $property = new ReflectionProperty($user, 'loginId');
        $property->setAccessible(true);
        $property->setValue($user, $userId);

        $credentials = $user->serialize();

        $property->setValue($user, 0);
        $user->setUsername(null);
        $user->unserialize($credentials);

        $this->assertEquals($userId, $user->getLoginId());
        $this->assertEquals($username, $user->getUsername());
    }

    public function testUserIsEqualToAnotherUser()
    {
        $user1 = new User;
        $user1->setUsername('orderware');

        $user2 = new User;
        $this->assertFalse($user1->isEqualTo($user2));

        $user2->setUsername($user1->getUsername());
        $this->assertTrue($user1->isEqualTo($user2));
    }

    /**
     * @dataProvider providerRoleAndEncoder
     */
    public function testGettingEncoderName($role, $encoder)
    {
        $user = new User;
        $user->setRole($role);

        $this->assertSame($encoder, $user->getEncoderName());
    }

    /**
     * @dataProvider providerRoleAndTester
     */
    public function testIsRole($role, $tester)
    {
        $user = new User;
        $method = new ReflectionMethod($user, $tester);
        $this->assertFalse($method->invoke($user));

        $user->setRole($role);
        $this->assertTrue($method->invoke($user));
    }

    public function providerRoleAndEncoder()
    {
        $provider = [
            [Constants::ROLE_STATELESS, Constants::ENCODER_STATELESS]
        ];

        return $provider;
    }

    public function providerRoleAndTester()
    {
        $provider = [
            [Constants::ROLE_STATELESS, 'isStateless']
        ];

        return $provider;
    }

}
