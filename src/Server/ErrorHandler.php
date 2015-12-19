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
 * ErrorHandler服务类
 *
 * @package  Norma
 * @subpackage  Server
 * @author    LunnLew <lunnlew@gmail.com>
 */
class ErrorHandler extends Factory
{
    /**
     * 服务驱动实例数组
     * @var array
     * @static
     * @access protected
     */
    protected static $instances = array();
    /**
     * 操作句柄数组
     * @var array
     * @static
     * @access protected
     */
    protected static $handlers = array();
    /**
     * 服务实例化函数
     *
     * @param  string $name    驱动名
     * @param  array  $options 驱动构造参数
     * @static
     * @return object 驱动实例
     */
    public static function factory($name = '', $options = array(), $default = 'MonologErrorHandler', $prex = 'Norma')
    {
        $called_class = get_called_class();
        $class_parts = explode('\\', $called_class);
        $server_name = array_pop($class_parts);

        if (empty($name)) {
            $name = C($server_name . ':default', RUN_ENGINE . $default);
        }
        $name = ucfirst($name);
        if (isset(self::$instances[$name])) {
            return self::$instances[$name];
        }
        $fac = $called_class . '\Factory';
        if (in_array(strtoupper(substr($name, 0, 3)), array(
            'LAE', 'BAE', 'SAE',
        ))) {
            $class = ErrorHandler\Factory::getRealServerName($name, $prex);
        } else {
            $class = ErrorHandler\Factory::getRealServerName(RUN_ENGINE . $name, $prex);
        }
        return (self::$instances[$name] = call_user_func_array("$class::register", $options));

    }
    /**
     * 注册句柄
     *
     * @param string  $name    驱动名
     * @param array   $options 驱动构造参数
     * @param Closure $closure 闭包函数
     * @static
     */
    public static function register($name = '', $options = array(), \Closure $closure = null)
    {
        $errorhandler = self::factory($name, $options);
        $closure($errorhandler);
    }
}
