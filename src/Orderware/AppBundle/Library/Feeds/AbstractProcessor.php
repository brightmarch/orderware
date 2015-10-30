<?php

namespace Orderware\AppBundle\Library\Feeds;

use Orderware\AppBundle\Entity\Feed;
use Orderware\AppBundle\Library\Services\JsonValidator;
use Orderware\AppBundle\Library\Status;

use Symfony\Component\Validator\Validator\ValidatorInterface;

use Doctrine\ORM\EntityManager;

use \Exception,
    \RuntimeException;

abstract class AbstractProcessor
{

    /** @var Doctrine\ORM\EntityManager */
    protected $entityManager;

    /** @var Orderware\AppBundle\Library\Services\JsonValidator */
    protected $jsonValidator;

    /** @var Symfony\Component\Validator\Validator\ValidatorInterface */
    protected $validator;

    /** @var object */
    protected $feedBody;

    /** @var array */
    protected $config = [];

    /** @var array */
    protected $records = [];

    /** @var string */
    protected $division;

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
     * @param string $division
     * @return boolean
     */
    public function run(Feed $feed)
    {
        $this->recordCount = 0;

        $this->division = $feed->getDivision()
            ->getDivision();

        $feed->setUpdatedBy(self::AUTHOR)
            ->setStatusId(Status::FEED_PROCESSING)
            ->setStartedAt(date_create());

        $_em = $this->entityManager;
        $_em->persist($feed);
        $_em->flush();

        try {
            $_conn = $_em->getConnection();
            $_conn->beginTransaction();

            // @todo Validate the JSON feed itself.

            // Parse the feed body into a JSON object.
            $this->feedBody = json_decode($feed->getFeedBody());

            $this->init();
            $this->process();

            $_conn->commit();
        } catch (Exception $e) {
            $_conn->rollback();

            $feed->setErrorMessage($e->getMessage());
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
     * Loads all records from a table for a division and converts
     * them into an easy to look-up hash map.
     *
     * @param string $recordName
     * @return AbstractProcessor
     */
    protected function loadRecords($recordName)
    {
        $config = $this->config[$recordName];

        // Load all the records first.
        $sql = sprintf("SELECT %s, %s FROM %s WHERE division = ?",
            $config['primary_key'], $config['unique_key'], $config['table_name']);

        $records = $this->entityManager
            ->getConnection()
            ->fetchAll($sql, [$this->division]);

        // Convert them into unique_key => primary_key format.
        $this->records[$recordName] = array_column(
            $records, $config['primary_key'], $config['unique_key']
        );

        return $this;
    }

    /**
     * Validates an entity and persists it to the database.
     *
     * @param string $recordName
     * @param array $record
     * @return mixed
     */
    protected function saveRecord($recordName, $record)
    {
        $config = $this->config[$recordName];

        // All records are counted, not just successful ones.
        $this->recordCount += 1;

        // Begin by performing the validation.
        $errors = $this->validator
            ->validate($record, $config['constraints']);

        if ($errors->count() > 0) {
            throw new RuntimeException(
                sprintf("Invalid %s%s at (%s): %s", $config['record_name'], $errors[0]->getPropertyPath(), $record[$config['unique_key']], $errors[0]->getMessage())
            );
        }

        // There are no errors, persist the record.
        $_conn = $this->entityManager
            ->getConnection();

        if (!$record[$config['primary_key']]) {
            // Generate a new primary key value from the sequence
            // so we can return it so further queries can use it.
            $identifier = $_conn->fetchColumn(
                sprintf("SELECT nextval('%s')", $config['sequence'])
            );

            // Store the identifier with the record.
            $record[$config['primary_key']] = $identifier;

            $_conn->insert($config['table_name'], $record + [
                'created_by' => $config['author']
            ]);
        } else {
            // Cache the identifier so it can be returned.
            $identifier = $record[$config['primary_key']];

            $_conn->update($config['table_name'], $record, [
                $config['primary_key'] => $identifier
            ]);
        }

        // Cache the newly inserted record so that if it is sent twice in a
        // feed, it can be looked up in the same transaction.
        $this->records[$recordName][$record[$config['unique_key']]] = $identifier;

        return $identifier;
    }

}
