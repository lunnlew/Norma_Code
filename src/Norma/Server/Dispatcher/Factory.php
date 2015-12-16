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

namespace Norma\Server\Dispatcher;

class Factory extends \Norma\Server\Factory
{
    public static function getServerName($name, $prex = '')
    {
        $server_name = 'Dispatcher';
        switch ($name) {
            case 'rest':
                $server_name = 'RESTDispatcher';
                break;
            case 'mvc':
            default:
                $server_name = 'Dispatcher';
                break;
        }

        return self::getApiName('Dispatcher', $server_name);
    }
}
