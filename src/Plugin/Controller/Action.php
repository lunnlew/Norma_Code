<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Plugin\Controller;

/**
 * Controller实现类
 */

class Action
{
    /**
     * 供插件管理器主动加载的入口
     */
    public function __construct()
    {
        //你想自动挂接的钩子列表
        \Norma\PluginManager::only('getControllerClass', array(&$this, 'register'));
    }
    /**
     * 注册控制器加载方法并返回控制器类
     * @param  array  $options [description]
     * @return [type] [description]
     */
    public function register($options = array())
    {
        if (C('MULTIPLE_GROUP')) {
            list($group, $module, $action) = array_values($options);
            !defined('GROUP_NAME') and define('GROUP_NAME', $group);
            $class = $group . '\Controller\\' . $module;
        } else {
            list($module, $action) = array_values($options);
            $class = 'Controller\\' . $module;
        }
        !defined('MODULE_NAME') and define('MODULE_NAME', ucwords($module));
        !defined('ACTION_NAME') and define('ACTION_NAME', $action);

        return $class;
    }
}
