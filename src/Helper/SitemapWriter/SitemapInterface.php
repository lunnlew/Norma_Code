<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Norma\Helper\SitemapWriter;

interface SitemapInterface
{
    /**
     * Add item
     * @param  \Norma\Helper\SitemapWriter\ItemInterface $item
     * @return $thisJ
     */
    public function addItem(ItemInterface $item);

    /**
     * Render XML
     * @return string
     */
    public function render();

    /**
     * Render XML
     * @return string
     */
    public function __toString();
}
