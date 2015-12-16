<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Addons\Demo;
use Plugin;

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
        \Core\Plugin\Manager::register('hello', array(&$this, 'sayHello'));
        \Core\Plugin\Manager::register('bye', 'Addons\Demo\Action::sayBye');
        \Core\Plugin\Manager::register('hi', 'Addons\Demo\Action::sayHi', array('demo'));
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
