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

namespace Norma\Server;

/**
 * 缓存服务类
 *
 * @package  Norma
 * @subpackage  Server
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Cache extends Factory
{

    /**
     * 服务实例化函数
     *
     * @param  string $name    驱动名
     * @param  array  $options 驱动构造参数
     * @static
     * @return object 驱动实例
     */
    public static function factory($name = '', $options = array(), $default = 'Memcache', $prex = 'Norma')
    {
        return parent::getFactory($name, $options, $default, $prex);
    }
}
