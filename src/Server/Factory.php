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
 * 服务工厂类
 *
 * @package  Norma
 * @subpackage  Server
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory
{
    /**
     * 服务驱动实例数组
     * @var array
     * @static
     * @access protected
     */
    protected static $instances = array();
    protected static $tpl = '\Server\%s\Drive\%s';
    /**
     * 服务实例化函数
     *
     * @param  string $name    驱动名
     * @param  array  $options 驱动构造参数
     * @static
     * @return object 驱动实例
     */
    public static function getFactory($name = '', $options = array(), $default = 'Server', $prex = 'Norma')
    {

        $called_class = get_called_class();
        $class_parts = explode('\\', $called_class);
        $server_name = array_pop($class_parts);
        if (empty($name)) {
            $name = C($server_name . ':default', RUN_ENGINE . $default);
        }
        $new_name = self::getServerName($name);
        if (isset(self::$instances[$new_name])) {
            return self::$instances[$new_name];
        }
        $fac = $called_class . '\Factory';
        return (self::$instances[$new_name] = $fac::getInstance($new_name, array_merge((Array) C($server_name . ':' . $name), (Array) $options), $prex));
    }
    /**
     * 服务实例化函数
     *
     * @param  string $name    驱动名
     * @param  array  $options 驱动构造参数
     * @static
     * @return object 驱动实例
     */
    public static function getFactoryByOriginal($name = '', $options = array(), $default = 'Server', $prex = 'Norma')
    {
        $called_class = get_called_class();
        $class_parts = explode('\\', $called_class);
        $server_name = array_pop($class_parts);
        if (empty($name)) {
            $name = C($server_name . ':default', $default);
        }

        if (isset(self::$instances[$name])) {
            return self::$instances[$name];
        }
        $fac = $called_class . '\Factory';
        return (self::$instances[$name] = $fac::getInstance($name, array_merge((Array) C($server_name . ':' . $name), (Array) $options), $prex));
    }
    public static function getServerName($name)
    {
        $name = ucfirst($name);
        if (!in_array(strtoupper(substr($name, 0, 3)), array(
            'LAE', 'BAE', 'SAE',
        ))) {
            return RUN_ENGINE . $name;
        }
    }
    /**
     * 获得服务驱动实例
     *
     * @final
     * @static
     * @return object 实例
     */
    public static function getInstance($class, $options = array(), $prex = 'Norma')
    {
        $class = static::getRealServerName($class, $prex);
        if (class_exists($class)) {
            return new $class(array_values(array_filter($options)));
        } else {
            throw new \Norma\Exception\RuntimeException('服务[' . $class . ']类未找到!');
        }
    }

    /**
     * 组装完整服务类名
     *
     * @access protected
     * @static
     * @return string 完整服务驱动类名
     */
    public static function getApiName($classify, $name, $prex = 'Norma')
    {
        if (empty($prex)) {
            $prex = 'Norma';
        }
        return vsprintf($prex . self::$tpl, array($classify, $name));
    }
}
