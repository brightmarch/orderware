<?php

namespace Orderware\AppBundle\Library\Services;

use Orderware\AppBundle\Library\Utils;

use JsonSchema\Uri\UriRetriever as JsonSchemaRetriever;
use JsonSchema\Validator as JsonSchemaValidator;

use \RuntimeException;

class JsonValidator
{

    public function __construct()
    {
    }

    public function validate($type, $jsonPayload)
    {
        $this->errors = [];

        // Decode the string to an object.
        $payload = json_decode($jsonPayload);

        // Construct a full path to the schema JSON.
        $schemaPath = realpath(
            sprintf(__DIR__ . '/../../Resources/public/schemas/%s_v1.schema.json', $type)
        );

        // Ensure the schema actually exists.
        if (!is_readable($schemaPath)) {
            throw new RuntimeException(sprintf("The schema (%s) could not be found.", $type));
        }

        // The validator requires a file URI.
        $schema = (new JsonSchemaRetriever)
            ->retrieve(sprintf('file://%s', $schemaPath));

        // Perform the actual validation.
        $validator = new JsonSchemaValidator;
        $validator->check($payload, $schema);

        if (!$validator->isValid()) {
            throw new RuntimeException(sprintf("The JSON provided is invalid (%s).", $validator->getErrors()[0]['message']));
        }

        return true;
    }

}
