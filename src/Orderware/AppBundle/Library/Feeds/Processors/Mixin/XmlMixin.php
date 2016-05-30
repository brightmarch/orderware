<?php

namespace Orderware\AppBundle\Library\Feeds\Processors\Mixin;

use \DOMDocument,
    \DOMNode,
    \DOMXPath;

trait XmlMixin
{

    /** @var DOMXPath */
    private $xpath;

    private function initializeDom()
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->loadXML($this->contents);

        $this->xpath = new DOMXpath($dom);

        return $this;
    }

    private function lookupPath($path, DOMNode $root = null, $maxlength = null)
    {
        $result = null;

        // Perform the query if initialized.
        if ($this->xpath instanceof DOMXpath) {
            $nodes = $this->xpath
                ->query($path, $root);

            if (1 === $nodes->length) {
                $result = trim($nodes->item(0)->textContent);

                if (is_int($maxlength)) {
                    $result = substr($result, 0, $maxlength);
                }
            }
        }

        return $result;
    }

}
