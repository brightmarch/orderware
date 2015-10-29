<?php

namespace Orderware\AppBundle\Tests\Resources;

use JsonSchema\Uri\UriRetriever;
use JsonSchema\Validator;

class SchemaTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerSchema
     */
    public function testSchemaValidates($schema, $example)
    {
        $prefix = __DIR__ . '/../../Resources/public/schemas/';

        $schemaPath = $prefix . $schema;
        $examplePath = $prefix . $example;

        $retriever = new UriRetriever;
        $schema = $retriever->retrieve(sprintf('file://%s', $schemaPath));

        $data = json_decode(file_get_contents($examplePath));

        $validator = new Validator;
        $validator->check($data, $schema);

        $this->assertTrue($validator->isValid());
    }

    public function providerSchema()
    {
        $provider = [
            ['feed_v1.schema.json', 'feed_v1.json'],
            ['inventory_v1.schema.json', 'inventory_v1.json'],
            ['order_v1.schema.json', 'order_v1.json'],
            ['product_v1.schema.json', 'product_v1.json']
        ];

        return $provider;
    }

}
