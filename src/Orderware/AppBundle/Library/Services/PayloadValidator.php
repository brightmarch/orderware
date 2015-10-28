<?php

namespace Orderware\AppBundle\Library\Services;

use Orderware\AppBundle\Library\Utils;

use JsonSchema\Uri\UriRetriever as SchemaRetriever;
use JsonSchema\Validator as SchemaValidator;

use \RuntimeException;

class PayloadValidator
{

    /** @var array */
    private $errors = [];

    public function __construct()
    {
    }

    public function validate($type, $payloadJson)
    {
        $this->errors = [];

        // Decode the string to an object.
        $payload = json_decode($payloadJson);

        // Construct a full path to the schema JSON.
        $schemaPath = realpath(
            sprintf(__DIR__ . '/../../Resources/public/schemas/%s_v1.schema.json', $type)
        );

        // Ensure the schema actually exists.
        if (!is_readable($schemaPath)) {
            throw new RuntimeException(sprintf("The schema (%s) could not be found.", $type));
        }

        // The validator requires a file URI.
        $schema = (new SchemaRetriever)
            ->retrieve(sprintf('file://%s', $schemaPath));

        // Perform the actual validation.
        $validator = new SchemaValidator;
        $validator->check($payload, $schema);

        if (!$validator->isValid()) {
            $this->errors = $validator->getErrors();
        }

        return !$this->hasErrors();
    }

    public function validateWithError($type, $payloadJson)
    {
        if (!$this->validate($type, $payloadJson)) {
            throw new RuntimeException(sprintf("The JSON provided is invalid (%s).", $this->errors[0]['message']));
        }

        return true;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function hasErrors()
    {
        return (count($this->errors) > 0);
    }

}
