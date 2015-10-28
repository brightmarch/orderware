<?php

namespace Orderware\AppBundle\Controller\Mixin;

trait GetterMixin
{

    private function author()
    {
        return $this->getUser()
            ->getUsername();
    }

}
