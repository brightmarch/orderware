<?php

namespace Orderware\AppBundle\Library\Feeds;

use Symfony\Component\DependencyInjection\Container;

use \RuntimeException;

class FeedProcessor
{

    /** @var Symfony\Component\DependencyInjection\Container */
    private $container;

    /** @var Doctrine\ORM\EntityManager */
    private $entityManager;

    /** @var string */
    private $localFile;

    public function __construct(Container $container)
    {
        $this->container = $container;

        $this->entityManager = $this->container
            ->get('doctrine')
            ->getManager('orderware');
    }

    public function process($account, $direction, $feedName)
    {
        // Get the feed configuration.
        $feed = $this->entityManager
            ->getRepository('Orderware:Feed')
            ->findOneBy([
                'account' => $account,
                'direction' => $direction,
                'name' => $feedName
            ]);

        if (!$feed) {
            throw new RuntimeException("dick butts");
        }


        // Immediately create a feed log record to ensure this always has a record of running.

        // Alias because this is going to be used a lot.

        // Get the feed configuration.

        // If inbound, get files.

        // Else if outbound, run feed and generate file.
    }

    public function setLocalFile($localFile)
    {
        $this->localFile = $localFile;

        return $this;
    }

}
