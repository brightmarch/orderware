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

    /** @const string */
    const AUTHOR = 'feed_processor';

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
            $account = $feed->getAccount();

            // Immediately record this processing attempt.
            $feedLog = new FeedLog;
            $feedLog->setAccount($account)
                ->setFeed($feed)
                ->setCreatedBy(self::AUTHOR)
                ->setUpdatedBy(self::AUTHOR)
                ->beginProcessing();

            $this->entityManager
                ->persist($feedLog);

            $this->entityManager
                ->flush($feedLog);

            if (!$feed->isEnabled()) {
                throw new InvalidArgumentException(sprintf("The feed (%s:%s) for (%s) is disabled and can not run.", $direction, $feedName, $account));
            }

            // Ensure the processor actually exists.
            $processor = $this->container
                ->get($feed->getService());

            // Associate the log with the
            // processor so it can access it.
            $processor->setFeedLog($feedLog);

            // Start main feed processing.
            if ($feed->isInbound()) {
                if (!$this->hasLocalFile()) {
                    $localFiles = [ ];
                } else {
                    // Associate the local file with the feed.
                    $localFiles = [$this->localFile];
                }

                foreach ($localFiles as $localFile) {
                    /*
                    $contents = file_get_contents($localFile);
                    $fileName = basename($localFile);

                    $feedLog->createFile($fileName, $contents);
                    */
                }
            }

            if ($feed->isOutbound()) {
                // Process the feed.

                // If local file, put contents there.

                // Else, generate file. Push it remotely.
            }
        } catch (Exception $e) {
            $feedLog->setErrorMessage($e->getMessage())
                ->setErrorFileName($e->getFile())
                ->setErrorLineNumber($e->getLine());
        }

        $feedLog->completeProcessing();

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

    private function hasLocalFile()
    {
        return (
            !empty($this->localFile) &&
            is_file($this->localFile)
        );
    }

}
