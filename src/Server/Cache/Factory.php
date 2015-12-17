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

namespace Norma\Server\Cache;

/**
 * 缓存工厂实现
 *
 * @package  Norma\Server\Cache
 * @author    LunnLew <lunnlew@gmail.com>
 * @final
 */
final class Factory extends \Norma\Server\Factory
{
    /**
     * 获取正式服务名
     * @param  string $name 服务名
     * @static
     * @return string 正式服务名
     */
    public static function getServerName($name, $prex = '')
    {
        $server_name = 'LAEMemcache';
        switch (strtolower($name)) {
            case 'file':
                $server_name = 'LAEFile';
                break;
            case 'memfile':
                $server_name = 'LAEMemfile';
                break;
        }

        return self::getApiName('Cache', $server_name);
    }
}
