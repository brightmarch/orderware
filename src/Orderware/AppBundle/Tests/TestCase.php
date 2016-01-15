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
            '@OrderwareAppBundle/Resources/config/fixtures/User.yml',
            '@OrderwareAppBundle/Resources/config/fixtures/Feed.yml',
            '@OrderwareAppBundle/Resources/config/fixtures/Items.yml',

            '@OrderwareAppBundle/Resources/config/fixtures/OrdImport.yml'
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
