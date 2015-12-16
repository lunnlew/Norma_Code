<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Server\Engine;

/**
 * 模板引擎工厂类
 *
 * @package  Norma
 * @subpackage  Server\Engine
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory extends \Norma\Server\Factory
{
    public static function getServerName($name, $prex = '')
    {
        $server_name = 'Smarty';
        switch ($name) {
            case 'twig':
                $server_name = 'Twig';
                break;
            case 'tengine':
                $server_name = 'Tengine';
                break;
            case 'smarty':
            default:
                $server_name = 'Smarty';
        }

        return self::getApiName('Engine', $server_name);
    }
}
