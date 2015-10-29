<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\Request;

use Symfony\Component\HttpFoundation\Request as HttpRequest;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class RequestTest extends \PHPUnit_Framework_TestCase
{

    public function testGettingTotalTimeFormatted()
    {
        $request = new Request;
        $this->assertEquals('0ms', $request->getTotalTimeFormatted());

        $request->setTotalTime(10);
        $this->assertEquals('10ms', $request->getTotalTimeFormatted());
    }

    public function testHasOrderNumber()
    {
        $request = new Request;
        $this->assertFalse($request->hasOrderNumber());

        $request->setOrderNumber('01111112');
        $this->assertTrue($request->hasOrderNumber());
    }

    public function testHasPayload()
    {
        $request = new Request;
        $this->assertFalse($request->hasPayload());

        $request->setPayload('{"payload":"test"}');
        $this->assertTrue($request->hasPayload());
    }

    public function testHasResponse()
    {
        $request = new Request;
        $this->assertFalse($request->hasResponse());

        $request->setResponse('{"response":"test"}');
        $this->assertTrue($request->hasResponse());
    }

    public function testCopyingRequest()
    {
        $httpRequest = new HttpRequest;
        $httpRequest->setMethod('post');
        $httpRequest->headers->add([
            'Content-Type' => 'application/json',
            'Accept' => '*/*',
            'User-Agent' => 'orderware/1.0'
        ]);

        $request = new Request;
        $this->assertNull($request->getAccept());
        $this->assertNull($request->getContentType());

        $request->copyRequest($httpRequest);

        $this->assertEquals('POST', $request->getRequestMethod());
        $this->assertEquals('application/json', $request->getContentType());
        $this->assertEquals('*/*', $request->getAccept());
        $this->assertEquals('orderware/1.0', $request->getUserAgent());
    }

    public function testCopyingResponse()
    {
        $content = '{"response":"test"}';
        $httpResponse = new HttpResponse($content, 202);

        $request = new Request;
        $this->assertEquals(0, $request->getStatusCode());
        $this->assertNull($request->getResponse());

        $request->copyResponse($httpResponse);

        $this->assertEquals(202, $request->getStatusCode());
        $this->assertEquals($content, $request->getResponse());
    }

    public function testTimer()
    {
        $request = new Request;
        $this->assertEquals(0, $request->getStartTime());
        $this->assertEquals(0, $request->getEndTime());
        $this->assertEquals(0, $request->getTotalTime());

        $request->startTimer();
        $this->assertGreaterThan(0, $request->getStartTime());
        $this->assertEquals(0, $request->getEndTime());

        usleep(20000);

        $request->stopTimer();
        $this->assertGreaterThan(0, $request->getEndTime());
        $this->assertGreaterThan(0, $request->getTotalTime());
    }

}
