<?php

namespace Orderware\AppBundle\Controller;

use Orderware\AppBundle\Controller\ApiControllerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ApiFeedsController extends Controller
    implements ApiControllerInterface
{

    use Mixin\GetterMixin;

    public function uploadAction(Request $request)
    {
        exit('upload');
    }

}
