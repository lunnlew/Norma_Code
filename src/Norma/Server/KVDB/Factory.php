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

namespace Norma\Server\KVDB;

class Factory extends \Norma\Server\Factory
{
    public static function getServerName($name, $prex = '')
    {
        $server_name = 'LAEKVDB';
        switch ($name) {
            case 'kvdb':
                if (RUN_ENGINE == 'SAE') {
                    if (function_exists('SAEKVDB')) {
                        $server_name = 'SAEKVDB';
                    }
                } elseif (RUN_ENGINE == 'BAE') {
                    if (class_exists('BaeKVDB')) {
                        $server_name = 'BaeKVDB';
                    }
                } else {
                    if (class_exists('KVDB')) {
                        $server_name = 'LAEKVDB';
                    }
                }

                break;
        }

        return self::getApiName('KVDB', $server_name);
    }
}
