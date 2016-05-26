<?php

namespace Orderware\AppBundle\Library\Feeds;

use Orderware\AppBundle\Entity\Feed;

use League\Flysystem\Filesystem as Mount;
use League\Flysystem\Adapter\Local as LocalAdapter;

use \ReflectionClass,
    \InvalidArgumentException,
    \RuntimeException;

class Filesystem
{

    /** @var Orderware\AppBundle\Entity\Feed */
    private $feed;

    /** @var League\Flysystem\Filesystem */
    private $local;

    /** @var League\Flysystem\Filesystem */
    private $remote;

    /** @var array */
    private $connectionTypes = [ ];

    /** @var string */
    private $localFile;

    /** @const string */
    const CONNECTION_LOCAL = 'local';

    public function __construct()
    {
        $this->connectionTypes = [
            self::CONNECTION_LOCAL => LocalAdapter::class
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
            $fileList = $this->remote->listContents();

            foreach ($fileList as $file) {
                $isMatched = preg_match(
                    $this->feed->getFilename(), $file['basename']
                );

                if ($isMatched) {
                    $contents = $this->remote
                        ->readAndDelete($file['basename']);

                    $this->local
                        ->put($file['basename'], $contents);

                    if ($this->local->has($file['basename'])) {
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

    public function writeRemoteFile() : bool
    {
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

    private function initialize() : bool
    {
        if (!$this->local && !$this->remote) {
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
            $this->local = new Mount(
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

            if (!$remoteAdapter) {
                throw new InvalidArgumentException(
                    sprintf("A remote filesystem could not be mounted. The connection type (%s) does not have an adapter.", $connectionType)
                );
            }

            $this->remote = new Mount($remoteAdapter);
        }

        return true;
    }

}
