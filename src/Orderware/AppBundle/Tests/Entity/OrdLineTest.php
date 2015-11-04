<?php

namespace Orderware\AppBundle\Tests\Entity;

use Orderware\AppBundle\Entity\Item;
use Orderware\AppBundle\Entity\OrdLine;

class OrdLineTest extends \PHPUnit_Framework_TestCase
{

    public function testSettingPickDescriptionIsUppercased()
    {
        $line = new OrdLine;
        $line->setPickDescription('sumatra coffee');

        $this->assertEquals('SUMATRA COFFEE', $line->getPickDescription());
    }


}
