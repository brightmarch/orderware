<?php

namespace Orderware\AppBundle\Controller;

use Orderware\AppBundle\Controller\ApiControllerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ApiOrdersController extends Controller
    implements ApiControllerInterface
{

    use Mixin\GetterMixin;

    public function importAction(Request $request)
    {
        exit('import');
    }

}
