<?php

namespace Orderware\AppBundle\Tests\Library\Feeds;

use Orderware\AppBundle\Tests\TestCase;

use \SimpleXMLElement;

class FeedValidatorTest extends TestCase
{

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The feed file (/tmp/invalid) does not exist.
     */
    public function testValidatingFeedRequiresFeedFileToExist()
    {
        $this->getContainer()
            ->get('orderware.feed_validator')
            ->validate('item', '1.0.0', '/tmp/invalid');
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The feed (invalid) at version (1.0.1) does not exist.
     */
    public function testValidatingFeedRequiresValidSchema()
    {
        $this->getContainer()
            ->get('orderware.feed_validator')
            ->validate('invalid', '1.0.1', __FILE__);
    }

    /**
     * @dataProvider providerInvalidFeed
     * @expectedException RuntimeException
     */
    public function testValidingInvalidFeed($schema, $version, $feedFile)
    {
        $feedPath = sprintf('%s/%s', __DIR__, $feedFile);

        $this->getContainer()
            ->get('orderware.feed_validator')
            ->validate($schema, $version, $feedPath);
    }

    /**
     * @dataProvider providerValidFeed
     */
    public function testValidatingFeed($schema, $version)
    {
        $schemaFile = sprintf('%s_%s.example.xml', $schema, $version);

        $feedPath = $this->getContainer()
            ->get('kernel')
            ->locateResource(sprintf('@OrderwareAppBundle/Resources/public/schemas/%s', $schemaFile));

        $xml = $this->getContainer()
            ->get('orderware.feed_validator')
            ->validate($schema, $version, $feedPath);

        $this->assertInstanceOf(SimpleXMLELement::class, $xml);
    }

    public function providerInvalidFeed()
    {
        $provider = [
            ['item', '1.0.0', 'item_feed_1.0.0_invalid1.xml']
        ];

        return $provider;
    }

    public function providerValidFeed()
    {
        $provider = [
            ['item', '1.0.0']
        ];

        return $provider;
    }

}
