<?php

namespace Orderware\AppBundle\Tests\Library\Orders;

use Orderware\AppBundle\Tests\TestCase;

class LoaderTest extends TestCase
{

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The order number (~) could not be found.
     */
    public function testLoadingOrderRequiresOrderToExist()
    {
        $this->getContainer()
            ->get('orderware.order_loader')
            ->load('GROWERS', '~');
    }

}
