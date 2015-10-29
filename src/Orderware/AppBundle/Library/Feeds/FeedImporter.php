<?php

namespace Orderware\AppBundle\Library\Feeds;

use Orderware\AppBundle\Entity\Feed;
use Orderware\AppBundle\Library\Services\JsonValidator;
use Orderware\AppBundle\Library\Status;

use Doctrine\ORM\EntityManager;

use \InvalidArgumentException,
    \RuntimeException;

class FeedImporter
{

    /** @var Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var Orderware\AppBundle\Library\Services\JsonValidator */
    protected $jsonValidator;

    /** @const string */
    const AUTHOR = 'feed_importer';

    public function __construct(EntityManager $entityManager, JsonValidator $jsonValidator)
    {
        $this->entityManager = $entityManager;
        $this->jsonValidator = $jsonValidator;
    }

    public function import($manifestFile, $feedFile)
    {
        // Ensure the manifest exists.
        if (!is_readable($manifestFile)) {
            throw new InvalidArgumentException(sprintf("The manifest file (%s) is not readable.", $manifestFile));
        }

        $manifestJson = file_get_contents($manifestFile);

        // Ensure the feed file exists.
        if (!is_readable($feedFile)) {
            throw new InvalidArgumentException(sprintf("The feed file (%s) is not readable.", $feedFile));
        }

        $feedJson = file_get_contents($feedFile);
        $feedHash = sha1_file($feedFile);

        // Ensure the manifest matches the schema.
        $this->jsonValidator
            ->validate('feed', $manifestJson);

        $manifest = json_decode($manifestJson);

        // Ensure the hashes match.
        if ($manifest->file_hash !== $feedHash) {
            throw new RuntimeException("The SHA1 hash of the feed file does not match the SHA1 hash in the manifest file.");
        }

        // Ensure the division exists.
        $division = $this->entityManager
            ->getRepository('Orderware:Division')
            ->findOneByDivision($manifest->division);

        if (!$division) {
            throw new InvalidArgumentException(sprintf("The division (%s) does not exist.", $manifest->division));
        }

        $feed = new Feed;
        $feed->setDivision($division)
            ->setCreatedBy(self::AUTHOR)
            ->setUpdatedBy(self::AUTHOR)
            ->setStatusId(Status::FEED_ENQUEUED)
            ->setFeedType($manifest->type)
            ->setFileHash($manifest->file_hash)
            ->setFileName($manifest->file_name)
            ->setFileSize(filesize($feedFile))
            ->setManifest($manifestJson)
            ->setFeedBody($feedJson);

        $_em = $this->entityManager;
        $_em->persist($feed);
        $_em->flush();

        return $feed;
    }

}
