<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Server\Storage;

/**
 * 工厂类
 *
 * @package  Norma
 * @subpackage  Server\Storage
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory extends \Norma\Server\Factory
{
    public static function getServerName($name, $prex = '')
    {
        return self::getApiName('Storage', $name);
    }
}
