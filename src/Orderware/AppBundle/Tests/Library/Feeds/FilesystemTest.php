<?php

namespace Orderware\AppBundle\Tests\Library\Feeds;

use Orderware\AppBundle\Entity\Feed;
use Orderware\AppBundle\Entity\FeedConnection;
use Orderware\AppBundle\Tests\TestCase;

use \ReflectionMethod;

class FilesystemTest extends TestCase
{

    /**
     * @expectedException RuntimeException
     * @expectedExceptionMessage The feed configuration has not been attached to the filesystem manager.
     */
    public function testInitializationRequiresFeedConfiguration()
    {
        $filesystem = $this->getContainer()
            ->get('orderware.feeds.filesystem');

        $method = new ReflectionMethod($filesystem, 'initialize');
        $method->setAccessible(true);
        $method->invoke($filesystem);
    }

    /**
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage The connection type (invalid) is not valid.
     */
    public function testInitializationRequiresValidConnectionType()
    {
        $connection = new FeedConnection;
        $connection->setType('invalid');

        $feed = new Feed;
        $feed->setConnection($connection);

        $filesystem = $this->getContainer()
            ->get('orderware.feeds.filesystem');

        $filesystem->setFeed($feed);

        $method = new ReflectionMethod($filesystem, 'initialize');
        $method->setAccessible(true);
        $method->invoke($filesystem);
    }

    public function testInitializingMemoryRemoteAdapter()
    {
        $connection = new FeedConnection;
        $connection->setType('memory');

        $feed = new Feed;
        $feed->setConnection($connection)
            ->setLocalRootDir('/tmp');

        $filesystem = $this->getContainer()
            ->get('orderware.feeds.filesystem');

        $filesystem->setFeed($feed);
        $this->assertFalse($filesystem->isMounted());

        $method = new ReflectionMethod($filesystem, 'initialize');
        $method->setAccessible(true);
        $method->invoke($filesystem);

        $this->assertTrue($filesystem->isMounted());
    }

    public function testCopyingRemoteFilesIsOverriddenByLocalFile()
    {
        $connection = new FeedConnection;
        $connection->setType('local');

        $feed = new Feed;
        $feed->setConnection($connection)
            ->setRemoteRootDir('/tmp')
            ->setLocalRootDir('/tmp');

        $filesystem = $this->getContainer()
            ->get('orderware.feeds.filesystem');

        $filesystem->setFeed($feed)
            ->setLocalFile(__DIR__ . '/localfile.test');

        $localFiles = $filesystem->copyRemoteFiles();

        $this->assertCount(1, $localFiles);
        $this->assertEquals('localfile.test', $localFiles[0]['basename']);
        $this->assertContains('localfile.test', $localFiles[0]['contents']);
    }

}
