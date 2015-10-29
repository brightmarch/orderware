<?php

namespace Orderware\AppBundle\Tests\Command;

use Orderware\AppBundle\Tests\TestCase;

class ProcessFeedCommandTest extends TestCase
{

    public function testCommandRequiresFeedIdArgument()
    {
        $output = $this->runCommand('orderware:process-feed');

        $this->assertContains('Not enough arguments (missing: "feed-id").', $output);
    }

    public function testProcessingFeedRequiresFeedToExist()
    {
        $output = $this->runCommand('orderware:process-feed', ['feed-id' => 0]);

        $this->assertContains("The feed (0) could not be found.", $output);
    }

    public function testProcessingFeed()
    {
        $output = $this->runCommand('orderware:process-feed', [
            'feed-id' => $this->fixtures['product_feed']->getFeedId()
        ]);

        $this->assertContains('Successfully processed feed "[product] feed.product.json"', $output);
    }

}
