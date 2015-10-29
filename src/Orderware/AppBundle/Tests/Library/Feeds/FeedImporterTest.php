<?php

namespace Orderware\AppBundle\Tests\Library\Feeds;

use Orderware\AppBundle\Entity\Feed;
use Orderware\AppBundle\Tests\TestCase;

class FeedImporterTest extends TestCase
{

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The manifest file (invalid.manifest) is not readable.
     */
    public function testManifestFileMustExist()
    {
        $feedFile = __DIR__ . '/feed.product.json';

        $importer = $this->getContainer()
            ->get('orderware.feed_importer');

        $importer->import('invalid.manifest', $feedFile);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The feed file (invalid.feed) is not readable.
     */
    public function testFeedFileMustExist()
    {
        $manifestFile = __DIR__ . '/manifest.product.json';

        $importer = $this->getContainer()
            ->get('orderware.feed_importer');

        $importer->import($manifestFile, 'invalid.feed');
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage The JSON provided is invalid (The property type is required).
     */
    public function testManifestMustBeValid()
    {
        $manifestFile = __DIR__ . '/manifest.invalid.json';
        $feedFile = __DIR__ . '/feed.product.json';

        $importer = $this->getContainer()
            ->get('orderware.feed_importer');

        $importer->import($manifestFile, $feedFile);
    }

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage The SHA1 hash of the feed file does not match the SHA1 hash in the manifest file.
     */
    public function testManifestHashMustMatchFileHash()
    {
        $manifestFile = __DIR__ . '/manifest.invalid_hash.json';
        $feedFile = __DIR__ . '/feed.product.json';

        $importer = $this->getContainer()
            ->get('orderware.feed_importer');

        $importer->import($manifestFile, $feedFile);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The division (INVALID) does not exist.
     */
    public function testDivisionMustExist()
    {
        $manifestFile = __DIR__ . '/manifest.invalid_division.json';
        $feedFile = __DIR__ . '/feed.product.json';

        $importer = $this->getContainer()
            ->get('orderware.feed_importer');

        $importer->import($manifestFile, $feedFile);
    }

    public function testImportingFeed()
    {
        $manifestFile = __DIR__ . '/manifest.product.json';
        $feedFile = __DIR__ . '/feed.product.json';

        $importer = $this->getContainer()
            ->get('orderware.feed_importer');

        $feed = $importer->import($manifestFile, $feedFile);

        $this->assertInstanceOf(Feed::class, $feed);
        $this->assertEquals('product', $feed->getFeedType());
        $this->assertTrue($feed->isEnqueued());
    }

}
