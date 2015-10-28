<?php

namespace Orderware\AppBundle\Tests\Library\Services;

use Orderware\AppBundle\Tests\TestCase;

use Symfony\Component\HttpFoundation\Response;

class ResponderTest extends TestCase
{

    public function testStandardResponse()
    {
        $response = $this->getContainer()
            ->get('responder')
            ->send('test', ['orderware' => 'test']);

        $json = json_decode($response->getContent());

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals('test', $json->type);
        $this->assertEquals('invalid', $json->request_id);
        $this->assertEquals('test', $json->data->orderware);
    }

    public function testChangingHttpStatusCode()
    {
        $response = $this->getContainer()
            ->get('responder')
            ->send('test', ['orderware' => 'test'], 404);

        $this->assertEquals(404, $response->getStatusCode());
    }

}
