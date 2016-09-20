<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace App\Plugin;

class demo {
	public function __construct() {
		\Norma\PluginManager::register('demo_app_plugin', array(&$this, 'demo_app_plugin'));
	}
	public function demo_app_plugin() {
		echo 'demo_app_plugin:Hello World!<br>';
	}
}