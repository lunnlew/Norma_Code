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
 * Storage服务类
 *
 * @package  Norma
 * @subpackage  Server
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Storage
{
    /**
     * 服务驱动实例数组
     * @var array
     * @static
     * @access protected
     */
    protected static $instances = array();
    /**
     * 服务实例化函数
     *
     * @param  string $name    驱动名
     * @param  array  $options 驱动构造参数
     * @static
     * @return object 驱动实例
     */
    public static function factory($name = '', $options = array())
    {
        $server_name = array_pop(explode('\\', __CLASS__));
        if (empty($name) || !is_string($name)) {
            $name = C($server_name . ':default', RUN_ENGINE . $server_name);
        }
        if (!isset(self::$instances[$name])) {
            $fac                    = __CLASS__ . '\Factory';
            self::$instances[$name] = $fac::getInstance($name, array_merge((Array) C($server_name . ':' . $name), (Array) $options));
        }

        return self::$instances[$name];
    }
}
