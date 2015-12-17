<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Plugin\Demo;

/**
 * 插件实现类 Demo
 *  Plugin::trigger('hello');
 *  Plugin::trigger('hi');
 *  Plugin::trigger('bye');
 */
class Action
{
    /**
     * 供插件管理器主动加载的入口
     * @param string $plugin 插件管理器
     */
    public function __construct()
    {
        //你想自动挂接的钩子列表
        \Norma\PluginManager::register('hello', array(&$this, 'sayHello'));
        \Norma\PluginManager::register('bye', 'Norma\Plugin\Demo\Action::sayBye');
        \Norma\PluginManager::register('hi', 'Norma\Plugin\Demo\Action::sayHi', array('demo'));
    }
    public function sayHello()
    {
        echo 'Hello World!<br>';
    }
    public static function sayBye()
    {
        echo 'Bye Bye!<br>';
    }
    public static function sayHi($name)
    {
        echo 'Hi! I am ' . $name . '.<br>';
    }
}
