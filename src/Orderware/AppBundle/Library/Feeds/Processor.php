<?php

namespace Orderware\AppBundle\Library\Feeds;

use Orderware\AppBundle\Entity\FeedLog;

use Symfony\Component\DependencyInjection\Container;

use \Exception,
    \InvalidArgumentException,
    \RuntimeException;

class Processor
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
            throw new InvalidArgumentException(sprintf("A feed (%s:%s) for (%s) could not be found.", $direction, $feedName, $account));
        }

        try {
            // Immediately record this processing attempt.
            $feedLog = new FeedLog;
            $feedLog->setAccount($feed->getAccount())
                ->setFeed($feed)
                ->setCreatedBy(self::AUTHOR)
                ->setUpdatedBy(self::AUTHOR);

            $this->entityManager
                ->persist($feedLog);

            $this->entityManager
                ->flush($feedLog);

            if (!$feed->isEnabled()) {
                throw new InvalidArgumentException(sprintf("The feed (%s:%s) for (%s) is disabled and can not run.", $direction, $feedName, $account));
            }

            // Start main feed processing.
        } catch (Exception $e) {
            $feedLog->setHasError(true)
                ->setErrorMessage($e->getMessage())
                ->setErrorFileName($e->getFile())
                ->setErrorLineNumber($e->getLine());
        }

        $this->entityManager
            ->persist($feedLog);

        $this->entityManager
            ->flush($feedLog);

        return $feedLog;
    }

    public function setLocalFile($localFile)
    {
        $this->localFile = $localFile;

        return $this;
    }

}
