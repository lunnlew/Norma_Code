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
namespace Norma\Server\Rank;

class Factory extends \Norma\Server\Factory
{
    public static function getServerName($name, $prex = '')
    {
        $server_name = 'LAERank';
        switch ($name) {
            case 'rank':
                if (RUN_ENGINE == 'SAE') {
                    if (function_exists('SAERank')) {
                        self::$cache_type = 'SAERank';
                    }
                } elseif (RUN_ENGINE == 'BAE') {
                    if (class_exists('BaeRank')) {
                        self::$cache_type = 'BaeRank';
                    }
                } else {
                    if (class_exists('Rank')) {
                        self::$cache_type = 'LAERank';
                    }
                }

                break;
        }

        return self::getApiName('Rank', $server_name);
    }
}
