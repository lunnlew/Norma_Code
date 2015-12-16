<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Server\Channel;

/**
 * Channel工厂类
 *
 * @package  Norma
 * @subpackage  Server\Channel
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory extends \Norma\Server\Factory
{
    public static function getServerName($name, $prex = '')
    {
        $server_name = 'LAEChannel';
        switch ($name) {
            case 'channel':
                if (RUN_ENGINE == 'SAE') {
                    if (function_exists('SAEChannel')) {
                        $server_name = 'SAEChannel';
                    }
                } elseif (RUN_ENGINE == 'BAE') {
                    if (class_exists('BaeChannel')) {
                        $server_name = 'BaeChannel';
                    }
                } else {
                    if (class_exists('Channel')) {
                        $server_name = 'LAEChannel';
                    }
                }

                break;
        }

        return self::getApiName('Channel', $server_name);
    }
}
