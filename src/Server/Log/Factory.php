<?php
// +----------------------------------------------------------------------
// | Norma
// +----------------------------------------------------------------------
// | Copyright (c) 2015  All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:  LunnLew <lunnlew@gmail.com>
// +----------------------------------------------------------------------

namespace Norma\Server\Log;

class Factory extends \Norma\Server\Factory
{
    public static function getServerName($name, $prex = '')
    {
        $server_name = 'Monolog';
        switch ($name) {
            case 'log':
                if (RUN_ENGINE == 'SAE') {
                    if (function_exists('SAELog')) {
                        $server_name = 'SAELog';
                    }
                } elseif (RUN_ENGINE == 'BAE') {
                    if (class_exists('BaeLog')) {
                        $server_name = 'BaeLog';
                    }
                } else {
                    if (class_exists('Log')) {
                        $server_name = 'LAELog';
                    }
                }
                break;
            case 'monolog':
            default:
                $server_name = 'Monolog';
                break;
        }

        return self::getApiName('Log', $server_name);
    }
}
