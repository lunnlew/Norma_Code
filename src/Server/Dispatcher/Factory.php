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
    public static function getRealServerName($name, $prex = 'Norma')
    {
        if (in_array($name, array(
            'Dispatcher',
            'RESTDispatcher',
        ))) {
            return self::getApiName('Dispatcher', $name, $prex);
        } else {
            return false;
        }
    }
}
