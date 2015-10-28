<?php

namespace Orderware\AppBundle\Controller;

use Orderware\AppBundle\Controller\ApiControllerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use \RuntimeException;

class ApiIndexController extends Controller
    implements ApiControllerInterface
{

    public function indexAction(Request $request)
    {
        $_params = $this->container
            ->getParameterBag()
            ->all();

        $data = [
            'version' => $_params['version'],
            'api_version' => $_params['api_version'],
            'build_date' => $_params['build_date']
        ];

        return $this->get('orderware.responder')
            ->send('heartbeat', $data);
    }

    public function errorAction(Request $request)
    {
        // This action intentionally throws an error to test
        // exception message data leakage and as a heartbeat
        // check in production.
        throw new RuntimeException("Error Request");
    }

}
