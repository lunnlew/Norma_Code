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
namespace Norma;

/**
 * OAPI
 *
 * @package  Norma
 * @subpackage  Service
 * @author    LunnLew <lunnlew@gmail.com>
 */
class OAPI
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
    public static function factory($name, $options = array(), $prex = 'Norma')
    {
        if (empty($name) || !is_string($name)) {
            return;
        }
        if (!isset(self::$instances[$name])) {
            $fac = __CLASS__ . '\Factory';
            self::$instances[$name] = $fac::getInstance($name, (Array) $options, $prex);
        }

        return self::$instances[$name];
    }
}
