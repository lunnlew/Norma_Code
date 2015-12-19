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
    public static function getRealServerName($name, $prex = 'Norma')
    {
        if (in_array($name, array(
            'LAEFile',
            'LAEMemcache',
            'LAEMemfile',
            'LAEapc',
            'LAEeaccelerator',
            'LAExcache',
            'SAEMemcache',
        ))) {
            return self::getApiName('Cache', $name, $prex);
        } else {
            return false;
        }

    }
}
