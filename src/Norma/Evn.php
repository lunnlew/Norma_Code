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
	public function Engine() {
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
	public function Mode() {
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
	public function OS() {
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
	 * 取得访问URL地址
	 * 注意:
	 * SERVER_NAME仅在ipv4下有效
	 * see:http://stackoverflow.com/questions/6768793/get-the-full-url-in-php
	 */
	public function RequestUri() {
		$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
		$protocol = substr(strtolower($_SERVER["SERVER_PROTOCOL"]), 0, strpos(strtolower($_SERVER["SERVER_PROTOCOL"]), "/")) . $s;
		$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
		return $protocol . "://" . self::getHost() . $port . $_SERVER['REQUEST_URI'];
	}

	/**
	 * 取得主机名
	 */
	public static function getHost() {
		if (isset($_SERVER['HTTP_X_FORWARDED_HOST']) && ($host = $_SERVER['HTTP_X_FORWARDED_HOST'])) {
			$elements = explode(',', $host);
			$host = trim(end($elements));
		} else {
			if (isset($_SERVER['HTTP_HOST']) && (!$host = $_SERVER['HTTP_HOST'])) {
				if (isset($_SERVER['SERVER_NAME']) && (!$host = $_SERVER['SERVER_NAME'])) {
					$host = !empty($_SERVER['SERVER_ADDR']) ? $_SERVER['SERVER_ADDR'] : '';
				}
			}
		}

		// Remove port number from host
		$host = preg_replace('/:\d+$/', '', $host);

		return trim($host);
	}
}
