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

class Initialize {
	/**
	 * 供插件管理器主动加载的入口
	 */
	public function __construct() {
		\Norma\Hook::set('appInitialize', array(&$this, 'deafultAppInitialize'));
		\Norma\Hook::set('coreAfterInitialize', array(&$this, 'defaultCoreAfterInitialize'));
		\Norma\Hook::set('appAfterInitialize', array(&$this, 'defaultAppAfterInitialize'));
	}

	public function deafultAppInitialize() {
		\Norma\Support\Evn::isWeb() && \Norma\Hook::loadPlugin(APP_LIB_PATH . '/Plugin', '');
	}

	public function defaultCoreAfterInitialize() {
	}

	public function defaultAppAfterInitialize() {
		//执行应用
		\Norma\App::execute('web');
	}
}
