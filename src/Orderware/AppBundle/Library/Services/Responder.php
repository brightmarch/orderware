<?php

namespace Orderware\AppBundle\Library\Services;

use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;

use JMS\Serializer\Serializer;

use \DateTime;

class Responder
{

    /** @var JMS\Serializer\Serializer */
    private $serializer;

    /** @var Symfony\Component\HttpFoundation\RequestStack */
    private $requestStack;

    public function __construct(Serializer $serializer, RequestStack $requestStack)
    {
        $this->serializer = $serializer;
        $this->requestStack = $requestStack;
    }

    public function send($type, $data, $status = 200)
    {
        $request = $this->requestStack
            ->getCurrentRequest();

        if ($request) {
            $requestId = $request->attributes
                ->get('request_id');
        } else {
            $requestId = 'invalid';
        }

        $data = [
            'type' => $type,
            'request_id' => $requestId,
            'request_time' => new DateTime,
            'data' => $data
        ];

        $content = $this->serializer
            ->serialize($data, 'json');

        $response = (new Response($content, $status, [
            'Content-Type' => 'application/json'
        ]))->setProtocolVersion('1.1');

        return $response;
    }

}
