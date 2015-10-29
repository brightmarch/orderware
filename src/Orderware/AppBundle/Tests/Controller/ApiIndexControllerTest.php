<?php

namespace Orderware\AppBundle\Tests\Controller;

use Orderware\AppBundle\Entity\Request;
use Orderware\AppBundle\Tests\TestCase;

class ApiIndexControllerTest extends TestCase
{

    public function testApiIndexRequiresAuthorization()
    {
        $client = static::makeClient();
        $client->request('GET', $this->getUrl('orderware_api_index'));

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testApiIndexReturnsHeartbeat()
    {
        $client = static::makeStatelessClient($this->fixtures['api_user']);
        $client->request('GET', $this->getUrl('orderware_api_index'));

        $json = json_decode($client->getResponse()->getContent());

        $this->assertStatusCode(200, $client);
        $this->assertEquals('heartbeat', $json->type);
    }

    public function testAuthorizedApiRequestsAreLogged()
    {
        $client = static::makeStatelessClient($this->fixtures['api_user']);
        $client->request('GET', $this->getUrl('orderware_api_index'));

        $json = json_decode($client->getResponse()->getContent());

        $request = $this->getContainer()
            ->get('doctrine')
            ->getManager('orderware')
            ->getRepository('Orderware:Request')
            ->findOneByRequestId($json->request_id);

        $this->assertNotNull($json->request_id);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertGreaterThan(0, $request->getLogId());
    }

    public function testAuthorizedApiRequestsAlwaysRespondWithJson()
    {
        $client = static::makeStatelessClient($this->fixtures['api_user']);
        $client->request('GET', '/api/v1/invalid-uri');

        $json = json_decode($client->getResponse()->getContent());

        $this->assertStatusCode(404, $client);
        $this->assertInternalType('object', $json);
        $this->assertEquals('No route found for "GET /api/v1/invalid-uri"', $json->data->message);
    }

    public function testApiExceptionMessagesAreHidden()
    {
        $client = static::makeStatelessClient($this->fixtures['api_user']);
        $client->request('GET', '/api/error');

        $json = json_decode($client->getResponse()->getContent());

        $this->assertStatusCode(500, $client);
        $this->assertNotEquals("Error Request", $json->data->message);
        $this->assertEquals("An unrecoverable error occurred during this request and has been logged.", $json->data->message);
    }

}
