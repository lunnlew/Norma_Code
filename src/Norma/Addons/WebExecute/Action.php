<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Addons\WebExecute;

/**
 * WebExecute
 */

class Action extends \Core\Plugin\Base
{
    /**
     * 供插件管理器主动加载的入口
     * @param string $plugin 插件管理器
     */
    public function __construct()
    {
        \Core\Plugin\Manager::only('WebExecute', array(&$this, 'run'));
    }
    public function run($options = array())
    {
        //控制器分发
        $dispatcher = \Norma\Server\Dispatcher::factory('mvc');
        $dispatcher->execute(
            hookTrigger('getControllerClass', array(\Norma\Request::$map_paths), '', true),
            \Norma\Request::$map_paths[C('VAR_ACTION', 'a')]
        );
        $Front = new \Core\Front\Advice\FrontAdvice;
        $Front->output();
    }
}
