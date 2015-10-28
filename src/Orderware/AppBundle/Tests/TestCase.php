<?php

namespace Orderware\AppBundle\Tests;

abstract class TestCase extends \Liip\FunctionalTestBundle\Test\WebTestCase
{

    public function setUp()
    {
        $fixtures = $this->loadFixtureFiles([
            '@OrderwareAppBundle/Resources/config/fixtures/Division.yml',
            '@OrderwareAppBundle/Resources/config/fixtures/User.yml'
        ]);
    }

}
