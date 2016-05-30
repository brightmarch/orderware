<?php

namespace Orderware\AppBundle\Library\Feeds\Processors\Mixin;

use \DOMDocument,
    \DOMNode,
    \DOMNodeList,
    \DOMXPath;

trait XmlMixin
{

    /** @var DOMXPath */
    private $xpath;

    /** @var DOMNode */
    private $xpathRoot;

    private function initializeDom()
    {
        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->loadXML($this->contents);

        $this->xpath = new DOMXpath($dom);

        return $this;
    }

    /**
     * Performs an xpath query if possible.
     *
     * @param string $query
     * @return mixed
     */
    private function xpathQuery($query)
    {
        if ($this->xpath instanceof DOMXpath) {
            return $this->xpath
                ->query($query, $this->xpathRoot);
        }

        return new DOMNodeList;
    }

    /**
     * Registers a root node for xpath queries.
     *
     * @param \DOMNode $root
     * @return XmlMixin
     */
    private function xpathRegisterRoot(DOMNode $root)
    {
        $this->xpathRoot = $root;

        return $this;
    }

    /**
     * Looks up a single value via xpath query.
     *
     * @param string $query
     * @param mixed $maxlength
     *
     * @return mixed
     */
    private function xpathLookup($query, $maxlength = null)
    {
        $result = null;

        // Perform the query if initialized.
        if ($this->xpath instanceof DOMXpath) {
            $nodes = $this->xpath
                ->query($query, $this->xpathRoot);

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
