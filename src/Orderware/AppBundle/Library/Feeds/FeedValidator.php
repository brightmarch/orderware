<?php

namespace Orderware\AppBundle\Library\Feeds;

class FeedValidator
{

    /** @var AppKernel */
    private $kernel;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    public function validate($feed, $version, $feedFile)
    {
    }

}
