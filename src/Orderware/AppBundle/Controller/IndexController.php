<?php

namespace Orderware\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class IndexController extends Controller
{

    public function indexAction()
    {
        return $this->render('OrderwareAppBundle:Index:index.html.twig');
    }

}
