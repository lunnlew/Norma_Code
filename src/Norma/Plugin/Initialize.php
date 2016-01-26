<?php
// +----------------------------------------------------------------------
// | Norma
// +----------------------------------------------------------------------
// | Copyright (c) 2015  All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:  LunnLew <lunnlew@gmail.com>
// +----------------------------------------------------------------------
namespace Norma\Plugin;

/**
 * Initialize
 */

class Initialize
{
	/**
	 * 供插件管理器主动加载的入口
	 */
	public function __construct() {
		\Norma\PluginManager::only('appInitialize', array(&$this, 'deafultAppInitialize'));
		\Norma\PluginManager::only('coreAfterInitialize', array(&$this, 'defaultCoreAfterInitialize'));
		\Norma\PluginManager::only('appAfterInitialize', array(&$this, 'defaultAppAfterInitialize'));
	}

	public function deafultAppInitialize() {
		RUN_MODE === 'WEB' && \Norma\PluginManager::loadPlugin(APP_PATH . 'Plugin', '');
	}

	public function defaultCoreAfterInitialize() {
	}

	public function defaultAppAfterInitialize() {
		//执行应用
		\Norma\App::execute('web');
	}
}
