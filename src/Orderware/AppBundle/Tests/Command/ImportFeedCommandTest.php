<?php

namespace Orderware\AppBundle\Tests\Command;

use Orderware\AppBundle\Tests\TestCase;

class ImportFeedCommandTest extends TestCase
{

    public function testCommandRequiresManifestFileAndFeedFileArguments()
    {
        $output = $this->runCommand('orderware:import-feed');

        $this->assertContains('Not enough arguments (missing: "manifest, feed").', $output);
    }

    public function testImportingFeed()
    {
        $output = $this->runCommand('orderware:import-feed', [
            'manifest' => __DIR__ . '/manifest.product.json',
            'feed' => __DIR__ . '/feed.product.json'
        ]);

        $this->assertContains('Successfully created feed "[product] feed.product.json"', $output);
    }

}
