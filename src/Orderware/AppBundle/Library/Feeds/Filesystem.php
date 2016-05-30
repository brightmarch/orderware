<?php

namespace Orderware\AppBundle\Library\Feeds;

use Orderware\AppBundle\Entity\Feed;

use League\Flysystem\Filesystem as Mount;
use League\Flysystem\Adapter\Local as LocalAdapter;
use League\Flysystem\Memory\MemoryAdapter;

use \ReflectionClass,
    \InvalidArgumentException,
    \RuntimeException;

class Filesystem
{

    /** @var Orderware\AppBundle\Entity\Feed */
    private $feed;

    /** @var League\Flysystem\Filesystem */
    private $localMount;

    /** @var League\Flysystem\Filesystem */
    private $remoteMount;

    /** @var array */
    private $connectionTypes = [ ];

    /** @var string */
    private $localFile;

    /** @const string */
    const CONNECTION_LOCAL = 'local';

    /** @const string */
    const CONNECTION_MEMORY = 'memory';

    public function __construct()
    {
        $this->connectionTypes = [
            self::CONNECTION_LOCAL => LocalAdapter::class,
            self::CONNECTION_MEMORY => MemoryAdapter::class
        ];
    }

    public function copyRemoteFiles() : array
    {
        $this->initialize();

        // Files that have been copied locally.
        $localFiles = [ ];

        if (is_file($this->localFile)) {
            $localFiles[] = [
                'basename' => basename($this->localFile),
                'contents' => file_get_contents($this->localFile)
            ];
        } else {
            // Get a list of files from the remote mount.
            $fileList = $this->remoteMount->listContents();

            foreach ($fileList as $file) {
                $isMatched = preg_match(
                    $this->feed->getFilename(), $file['basename']
                );

                if ($isMatched) {
                    $contents = $this->remoteMount
                        ->readAndDelete($file['basename']);

                    $this->localMount
                        ->put($file['basename'], $contents);

                    if ($this->localMount->has($file['basename'])) {
                        $localFiles[] = [
                            'basename' => $file['basename'],
                            'contents' => $contents
                        ];
                    }
                }
            }
        }

        return $localFiles;
    }

    public function writeRemoteFile(string $fileName, string $contents) : bool
    {
        if (!empty($this->localFile)) {
            file_put_contents($this->localFile, $contents);
        } else {
            // Write the file on the local mount first.
            $this->localMount->put($fileName, $contents);

            // And then write it on the remote mount.
            $this->remoteMount->put($fileName, $contents);
        }

        return true;
    }

    public function isMounted() : bool
    {
        return (
            $this->localMount instanceof Mount &&
            $this->remoteMount instanceof Mount 
        );
    }

    public function setFeed(Feed $feed) : Filesystem
    {
        $this->feed = $feed;

        return $this;
    }

    public function setLocalFile($localFile) : Filesystem
    {
        $this->localFile = $localFile;

        return $this;
    }

    public function getLocalMount()
    {
        return $this->localMount;
    }

    public function getRemoteMount()
    {
        return $this->remoteMount;
    }

    private function initialize() : bool
    {
        if (!$this->isMounted()) {
            if (!$this->feed) {
                throw new RuntimeException("The feed configuration has not been attached to the filesystem manager.");
            }

            $connection = $this->feed
                ->getConnection();

            // This is used frequently and makes for cleaner code.
            $connectionType = $connection->getType();

            if (!array_key_exists($connectionType, $this->connectionTypes)) {
                throw new InvalidArgumentException(sprintf("The connection type (%s) is not valid.", $connectionType));
            }

            // Construct a local mount of the filesystem.
            // This always uses the LocalAdapter from Flysystem.
            $this->localMount = new Mount(
                new LocalAdapter($this->feed->getLocalRootDir())
            );

            // Construct a remote mount of the filesystem.
            // This adapter can change from feed to feed.
            $remoteAdapter = null;

            $class = new ReflectionClass(
                $this->connectionTypes[$connectionType]
            );

            // Because each adapter takes separate arguments,
            // we have to carefully construct each one.
            if (self::CONNECTION_LOCAL === $connectionType) {
                $remoteAdapter = $class->newInstance(
                    $this->feed->getRemoteRootDir()
                );
            }

            if (self::CONNECTION_MEMORY === $connectionType) {
                $remoteAdapter = $class->newInstance();
            }

            $this->remoteMount = new Mount($remoteAdapter);
        }

        return true;
    }

}
