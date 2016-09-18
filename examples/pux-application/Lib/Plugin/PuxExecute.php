<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace App\Plugin;

/**
 * PuxExecute
 */

class PuxExecute {
	/**
	 * 供插件管理器主动加载的入口
	 */
	public function __construct() {
		\Norma\PluginManager::set('PuxExecute', array(&$this, 'run'));
	}
	public function run($options = array()) {
		$mux = require APP_PATH . 'Data/mux.php';
		$route = $mux->dispatch($_SERVER['PATH_INFO']);
		$res = \Pux\Executor::execute($route);

		if (!empty($res)) {
			\Norma\PluginManager::trigger('output', array($res), '', true);
			unset($res);
		}
	}
}
