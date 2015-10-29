<?php

namespace Orderware\AppBundle\Tests\Controller;

use Orderware\AppBundle\Tests\TestCase;

class IndexControllerTest extends TestCase
{

    public function testIndex()
    {
        $client = static::makeClient();
        $client->request('GET', $this->getUrl('orderware_index'));

        $this->assertStatusCode(200, $client);
    }

}
