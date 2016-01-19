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

        // Use internal XML error reporting to trap the errors.
        libxml_use_internal_errors(true);

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->load($feedPath);

        // Validate the feed file against the XSD. Report any errors and stop.
        $dom->schemaValidate($schemaPath);
        $errors = libxml_get_errors();

        if (count($errors) > 0) {
            throw new RuntimeException(sprintf("The feed file (%s) failed to validate for the following reason: %s", $feedPath, $errors[0]->message));
        }

        return simplexml_import_dom($dom);
    }

}
