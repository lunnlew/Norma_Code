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
namespace Norma;

class Evn {
	/**
	 * 获取当前的应用引擎环境
	 */
	public static function Engine() {
		if (!defined('RUN_ENGINE')) {
			if (defined('SAE_ACCESSKEY')) {
				define('RUN_ENGINE', 'SAE');
			} elseif (isset($_SERVER['HTTP_BAE_ENV_APPID'])) {
				define('RUN_ENGINE', 'BAE');
			} else {
				define('RUN_ENGINE', 'LAE');
			}
		}
		return RUN_ENGINE;
	}
	/**
	 * 获取当前的运行模式
	 */
	public static function Mode() {
		if (!defined('RUN_MODE')) {
			if (PHP_SAPI == 'cli') {
				define('RUN_MODE', 'CLI');
				//--处于CLI模式
			} else {
				define('RUN_MODE', 'WEB');
				//--处于WEB模式
			}
		}
		return RUN_MODE;
	}
	/**
	 * 获取操作系统
	 */
	public static function OS() {
		if (!defined('OS')) {
			if (strstr(PHP_OS, 'WIN')) {
				define('OS', 'WIN');
				//--处于WIN
			} else {
				define('OS', 'LINUX');
				//--处于linux
			}
		}
		return OS;
	}
	/**
	 * 获取兼容支持目录
	 */
	public static function getCompatibilityPath() {
		return FRAME_PATH . 'Compatibility/';
	}

}
