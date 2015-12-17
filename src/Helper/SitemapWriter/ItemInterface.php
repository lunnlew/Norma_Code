<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Norma\Helper\SitemapWriter;

interface ItemInterface
{
    /**
     * Set item loc
     * @param  string $loc
     * @return $this
     */
    public function loc($loc);
    /**
     * Set item lastmod
     * @param  string $lastmod
     * @return $this
     */
    public function lastmod($lastmod);
    /**
     * Set item changefreq
     * @param  string $changefreq
     * @return $this
     */
    public function changefreq($changefreq);
    /**
     * Set item priority
     * @param  string $priority
     * @return $this
     */
    public function priority($priority);
    /**
     * Append item to the sitemap
     * @param  \Norma\Helper\SitemapWriter\SitemapInterface $sitemap
     * @return $this
     */
    public function appendTo(SitemapInterface $sitemap);

    /**
     * Return XML object
     * @return \Norma\Helper\SitemapWriter\SimpleXMLElement
     */
    public function asXML();
}
