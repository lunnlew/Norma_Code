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
namespace Norma\Support;

class Evn {
	static $accessMode = 'web';
	public static function DetectAccessMode() {
		return (self::$accessMode = (PHP_SAPI == 'cli') ?: 'web');
	}

	static $os = 'win';
	public static function DetectOS() {
		return (self::$os = (strstr(PHP_OS, 'win')) ? 'win' : 'linux');
	}

	static $runEngine = 'lae';
	static $runEngineEx = '';
	public static function DetectEngine() {
		if (defined('SAE_ACCESSKEY')) {
			self::$runEngine = 'sae';
			if (is_writeable(APP_PATH)) {
				self::$runEngineEx = 'saewrite';
			}
		} elseif (isset($_SERVER['HTTP_BAE_ENV_APPID'])) {
			self::$runEngine = 'bae';
		} else {
			self::$runEngine = 'lae';
		}
		return self::$runEngine;
	}

	public static function isCli() {
		return self::$accessMode == 'cli';
	}

	public static function isWeb() {
		return self::$accessMode == 'web';
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