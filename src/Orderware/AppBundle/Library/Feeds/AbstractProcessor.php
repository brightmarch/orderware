<?php

namespace Orderware\AppBundle\Library\Feeds;

use Orderware\AppBundle\Entity\Feed;
use Orderware\AppBundle\Library\Services\JsonValidator;
use Orderware\AppBundle\Library\Status;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\EntityManager;

use \Exception,
    \ReflectionClass,
    \RuntimeException;

abstract class AbstractProcessor
{

    /** @var Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var Orderware\AppBundle\Library\Services\JsonValidator */
    protected $jsonValidator;

    /** @var Symfony\Component\Validator\Validator\ValidatorInterface */
    protected $validator;

    /** @var Orderware\AppBundle\Entity\Feed */
    protected $feed;

    /** @var Orderware\AppBundle\Entity\Division */
    protected $division;

    /** @var object */
    protected $feedBody;

    /** @var integer */
    protected $recordCount = 0;

    /** @const string */
    const AUTHOR = 'feed_processor';

    public function __construct(
        EntityManager $entityManager,
        ValidatorInterface $validator,
        JsonValidator $jsonValidator
    )
    {
        $this->entityManager = $entityManager;
        $this->validator = $validator;
        $this->jsonValidator = $jsonValidator;
    }

    /**
     * Wrapper for running an individual feed. If the JSON validates,
     * it is sent to the process() method to be processed. The feed itself
     * is updated before and after processing for reporting purposes.
     *
     * @param Orderware\AppBundle\Entity\Feed $feed
     * @return boolean
     */
    public function run(Feed $feed)
    {
        $this->feed = $feed;
        $this->division = $feed->getDivision();
        $this->recordCount = 0;

        $feed->setUpdatedBy(self::AUTHOR)
            ->setStatusId(Status::FEED_PROCESSING)
            ->setStartedAt(date_create())
            ->setRecordCount($this->recordCount);

        $_em = $this->entityManager;
        $_em->persist($feed);
        $_em->flush();

        try {
            $_conn = $_em->getConnection();
            $_conn->beginTransaction();

            // Validate the JSON feed itself.
            $this->jsonValidator->validate(
                $feed->getFeedType(), $feed->getFeedBody()
            );

            // Parse the feed body into a JSON object.
            $this->feedBody = json_decode($feed->getFeedBody());
            $this->process();

            $_conn->commit();
        } catch (Exception $e) {
            $_conn->rollback();

            $feed->setErrorMessage(
                $e->getMessage()
            );
        }

        $feed->setStatusId(Status::FEED_PROCESSED)
            ->setFinishedAt(date_create())
            ->setMemoryUsage(memory_get_peak_usage())
            ->setRecordCount($this->recordCount)
            ->calculate();
    
        $_em->persist($feed);
        $_em->flush();

        return $feed;
    }

    /**
     * Processes the feed.
     *
     * @return boolean
     */
    abstract protected function process();

    /**
     * Validates an entity and persists it to the database.
     *
     * @param object $record
     * @return mixed
     */
    protected function saveRecord($record)
    {
        // All records are counted, not just successful ones.
        $this->recordCount += 1;

        // Begin by performing the validation.
        $errors = $this->validator
            ->validate($record);

        if ($errors->count() > 0) {
            $object = (new ReflectionClass($record))
                ->getShortName();

            throw new RuntimeException(sprintf("Invalid %s.%s: %s", $object, $errors[0]->getPropertyPath(), $errors[0]->getMessage()));
        }

        $this->entityManager
            ->persist($record);

        return true;
    }

}
