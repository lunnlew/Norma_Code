<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Norma\Helper\SitemapWriter;

use \DOMDocument;

class Sitemap implements \Norma\Helper\SitemapWriter\SitemapInterface
{
    /**
     * tpl tpl
     * @var string
     */
    protected $tpl = '<urlset />';
    /** @var \Norma\Helper\SitemapWriter\ItemInterface[] */
    protected $items = array();
    /**
     * [__construct description]
     * @param string $tpl
     */
    public function __construct($tpl = null)
    {
        if ($tpl !== null) {
            $this->tpl = $tpl;
        }
    }
    /**
     * Add item
     * @param  \Norma\Helper\SitemapWriter\ItemInterface $item
     * @return $this
     */
    public function addItem(ItemInterface $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Render XML
     * @return string
     */
    public function render()
    {
        $xml = new SimpleXMLElement($this->tpl, LIBXML_NOERROR|LIBXML_ERR_NONE|LIBXML_ERR_FATAL);

        foreach ($this->items as $item) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($item->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        $dom = new DOMDocument('1.0', 'UTF-8');
        $dom->appendChild($dom->importNode(dom_import_simplexml($xml), true));
        $dom->formatOutput = true;

        return $dom->saveXML();
    }

    /**
     * Render XML
     * @return string
     */
    public function __toString()
    {
        return $this->render();
    }
}
