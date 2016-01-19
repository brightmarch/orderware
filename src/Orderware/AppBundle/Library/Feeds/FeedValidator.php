<?php

namespace Orderware\AppBundle\Library\Feeds;

use Symfony\Component\HttpKernel\Kernel;

use \DOMDocument;

use \InvalidArgumentException,
    \RuntimeException;

class FeedValidator
{

    /** @var Symfony\Component\HttpKernel\Kernel */
    private $kernel;

    public function __construct(Kernel $kernel)
    {
        $this->kernel = $kernel;
    }

    public function validate($schema, $version, $feedPath)
    {
        // Ensure the path to the feed file is valid.
        if (!is_file($feedPath)) {
            throw new InvalidArgumentException(sprintf("The feed file (%s) does not exist.", $feedPath));
        }

        // Get the corresponding XSD to validate the feed against.
        $schemaFile = sprintf('%s_%s.schema.xsd', $schema, $version);

        try {
            $schemaPath = $this->kernel
                ->locateResource(sprintf('@OrderwareAppBundle/Resources/public/schemas/%s', $schemaFile));
        } catch (InvalidArgumentException $e) {
            throw new InvalidArgumentException(sprintf("The feed (%s) at version (%s) does not exist.", $schema, $version));
        }

        // Use internal XML error reporting to capture the errors.
        libxml_use_internal_errors(true);

        // Clear any previous errors to ensure we only capture
        // the errors actually thrown by this validation attempt.
        libxml_clear_errors();

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load($feedPath);

        // Actually perform the validation against the schema.
        if (!$dom->schemaValidate($schemaPath)) {
            $errors = libxml_get_errors();

            throw new RuntimeException(sprintf("The feed file (%s) failed to validate for the following reason: %s", $feedPath, $errors[0]->message));
        }

        // Convert the DOMDocument into a SimpleXMLElement object
        // because SimpleXML is just so much easier to work with.
        $xml = simplexml_import_dom($dom);

        return $xml;
    }

}
