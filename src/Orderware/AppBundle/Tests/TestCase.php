<?php

namespace Orderware\AppBundle\Tests;

use Symfony\Component\Security\Core\User\UserInterface;

abstract class TestCase extends \Liip\FunctionalTestBundle\Test\WebTestCase
{

    /** @var array */
    protected $fixtures = [ ];

    public function setUp()
    {
        $this->fixtures = $this->loadFixtureFiles([
            '@OrderwareAppBundle/Resources/config/fixtures/Account.yml',
            '@OrderwareAppBundle/Resources/config/fixtures/Feeds.yml'
        ]);
    }

    protected function makeStatelessClient(UserInterface $user)
    {
        return static::makeClient([
            'username' => $user->getUsername(),
            'password' => $user->getPassword()
        ]);
    }

}
