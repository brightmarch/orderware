<?php

namespace Orderware\AppBundle\Tests\Controller;

use Orderware\AppBundle\Entity\Request;
use Orderware\AppBundle\Tests\TestCase;

class ApiIndexControllerTest extends TestCase
{

    public function testApiIndexRequiresAuthorization()
    {
        $client = $this->makeClient();
        $client->request('GET', $this->getUrl('orderware_api_index'));

        $this->assertEquals(401, $client->getResponse()->getStatusCode());
    }

    public function testApiIndexReturnsHeartbeat()
    {
        $client = $this->makeStatelessClient($this->fixtures['api_user']);
        $client->request('GET', $this->getUrl('orderware_api_index'));

        $json = json_decode($client->getResponse()->getContent());

        $this->assertStatusCode(200, $client);
        $this->assertEquals('heartbeat', $json->type);
    }

    public function testAuthorizedApiRequestsAreLogged()
    {
        $user = $this->getFixture('api_user', 'orderware');

        $client = $this->authenticateStateless($user);
        $client->request('GET', $this->getUrl('orderware_api_index'));

        $requestId = json_decode(
            $client->getResponse()->getContent()
        )->request_id;

        $request = $this->get('doctrine')
            ->getManager('orderware')
            ->getRepository('Orderware:Request')
            ->findOneByRequestId($requestId);

        $this->assertNotNull($requestId);
        $this->assertInstanceOf(Request::class, $request);
        $this->assertGreaterThan(0, $request->getLogId());
    }

    public function testAuthorizedApiRequestsAlwaysRespondWithJson()
    {
        $user = $this->getFixture('api_user', 'orderware');

        $client = $this->authenticateStateless($user);
        $client->request('GET', '/api/v1/invalid-uri');

        $json = json_decode($client->getResponse()->getContent());

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
        $this->assertInternalType('object', $json);
        $this->assertInstanceOf(\StdClass::class, $json);
        $this->assertEquals('No route found for "GET /api/v1/invalid-uri"', $json->data->message);
    }

    public function testApiExceptionMessagesAreHidden()
    {
        $user = $this->getFixture('api_user', 'orderware');

        $client = $this->authenticateStateless($user);
        $client->request('GET', '/api/error');

        $json = json_decode($client->getResponse()->getContent());

        $this->assertEquals(500, $client->getResponse()->getStatusCode());
        $this->assertNotEquals("Error Request", $json->data->message);
        $this->assertEquals("An unrecoverable error occurred during this request and has been logged.", $json->data->message);
    }

}
