<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Service;

/**
 * 数据收集器服务类
 *
 * @package  Norma
 * @subpackage  Service
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Collection extends Factory
{

    /**
     * 服务实例化函数
     *
     * @param  string $name    驱动名
     * @param  array  $options 驱动构造参数
     * @static
     * @return object 驱动实例
     */
    public static function factory($name = '', $options = array(), $default = 'Data', $prex = 'Norma')
    {
        return self::getFactory($name, $options, $default, $prex);
    }
}
