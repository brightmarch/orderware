<?php

namespace Orderware\AppBundle\Tests;

use Symfony\Component\Security\Core\User\UserInterface;

abstract class TestCase extends \Liip\FunctionalTestBundle\Test\WebTestCase
{

    /** @var array */
    protected $fixtures = [];

    public function setUp()
    {
        $this->fixtures = $this->loadFixtureFiles([
            '@OrderwareAppBundle/Resources/config/fixtures/Division.yml',
            '@OrderwareAppBundle/Resources/config/fixtures/User.yml'
        ]);
    }

    protected function makeStatelessClient(UserInterface $user)
    {
        return static::makeClient([
            'PHP_AUTH_USER' => $user->getUsername(),
            'PHP_AUTH_PW' => $user->getPassword()
        ]);
    }

}
