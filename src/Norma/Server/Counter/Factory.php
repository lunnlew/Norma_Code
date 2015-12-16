<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Server\Counter;

/**
 * Counter工厂类
 *
 * @package  Norma
 * @subpackage  Server\Counter
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory extends \Norma\Server\Factory
{
    public static function getServerName($name, $prex = '')
    {
        $server_name = 'LAECounter';
        switch ($name) {
            case 'counter':
                if (RUN_ENGINE == 'SAE') {
                    if (function_exists('SAECounter')) {
                        $server_name = 'SAECounter';
                    }
                } elseif (RUN_ENGINE == 'BAE') {
                    if (class_exists('BaeCounter')) {
                        $server_name = 'BaeCounter';
                    }
                } else {
                    if (class_exists('Counter')) {
                        $server_name = 'LAECounter';
                    }
                }

                break;
        }

        return self::getApiName('Counter', $server_name);
    }
}
