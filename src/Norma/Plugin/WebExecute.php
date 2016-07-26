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

class WebExecute {
	/**
	 * 供插件管理器主动加载的入口
	 */
	public function __construct() {
		\Norma\PluginManager::set('WebExecute', array(&$this, 'run'));
	}
	public function run($options = array()) {
		//控制器分发
		$dispatcher = \Norma\Service\Dispatcher::getInstance('MVCDispatcher');
		$map_params = array();
		$method = '';
		$res = $dispatcher->execute(
			\Norma\PluginManager::trigger('getControllerClass', $map_params, '', true),
			$method
		);
		if (!empty($res)) {
			\Norma\PluginManager::trigger('output', array($res), '', true);
			unset($res);
		}
	}
}
