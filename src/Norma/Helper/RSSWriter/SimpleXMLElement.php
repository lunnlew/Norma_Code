<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Norma\Helper\RSSWriter;

class SimpleXMLElement extends \SimpleXMLElement
{
    public function addChild($name, $value = null, $namespace = null)
    {
        if ($value !== null and is_string($value) === true) {
            $value = str_replace(array('&'), array('&amp;'), $value);
        }
        //<![CDATA[ ?
        return parent::addChild($name, $value, $namespace);
    }
}
