<?php

namespace Orderware\AppBundle\Library\Feeds;

use Orderware\AppBundle\Entity\Feed;

use \InvalidArgumentException;

class Filesystem
{

    /** @var Orderware\AppBundle\Entity\Feed */
    private $feed;

    private $local;

    private $remote;

    /** @var string */
    private $localFile;

    public function __construct()
    {
    }

    public function copyRemoteFiles() : array
    {
        $this->initialize();

        if (is_file($this->localFile)) {
            //return [$this->localFile];
            return [ ];
        }

        return [ ];
    }

    public function openLocalFile(string $fileName) : string
    {
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
                throw new RuntimeException("A Feed entity has not been attached to the filesystem manager.");
            }
        }

        return true;
    }

}
