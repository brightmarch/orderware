<?php

namespace Orderware\AppBundle\Tests\Library\Feeds;

use Orderware\AppBundle\Tests\TestCase;

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

    public function testValidatingFeed()
    {

    }

    public function providerInvalidFeed()
    {
        $provider = [
            ['item', '1.0.0', 'item_feed_1.0.0_invalid1.xml']
        ];

        return $provider;
    }

}
