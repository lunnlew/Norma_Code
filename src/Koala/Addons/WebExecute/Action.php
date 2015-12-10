<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\Addons\WebExecute;
/**
 * WebExecute
 */

class Action extends \Core\Plugin\Base {
	/**
	 * 供插件管理器主动加载的入口
	 * @param string $plugin 插件管理器
	 */
	function __construct() {
		\Core\Plugin\Manager::only('WebExecute', array(&$this, 'run'));
	}
	public function run($options = array()) {
		//控制器分发
		$dispatcher = \Koala\Server\Dispatcher::factory('mvc');
		$dispatcher->execute(
			hookTrigger('getControllerClass', array(\Request::$map_paths), '', true),
			\Request::$map_paths[C('VAR_ACTION', 'a')]
		);
		$Front = new \Core\Front\Advice\FrontAdvice;
		$Front->output();
	}
}