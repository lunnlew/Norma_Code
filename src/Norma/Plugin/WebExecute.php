<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Plugin;

/**
 * WebExecute
 */

class WebExecute
{
    /**
     * 供插件管理器主动加载的入口
     */
    public function __construct()
    {
        \Norma\PluginManager::only('WebExecute', array(&$this, 'run'));
    }
    public function run($options = array())
    {
        //控制器分发
        $dispatcher = \Norma\Service\Dispatcher::getInstance('MVCDispatcher');
        $dispatcher->execute(
            \Norma\hookTrigger('getControllerClass', array(\Norma\Request::$map_paths), '', true),
            \Norma\Request::$map_paths[\Norma\C('VAR_ACTION', 'a')]
        );

    }
}
