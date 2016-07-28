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
 * Reject
 */

class Reject {
	/**
	 * 供插件管理器主动加载的入口
	 */
	public function __construct() {
		\Norma\PluginManager::set('reject_request_check', array(&$this, 'rejectRequestCheck'));
	}
	/**
	 * 白名单机制的请求域检测
	 * http://stackoverflow.com/questions/1459739/php-serverhttp-host-vs-serverserver-name-am-i-understanding-the-ma/28889208#28889208
	 */
	public function rejectRequestCheck() {
		$reject_request = true;
		if (array_key_exists('HTTP_HOST', $_SERVER)) {
			$host_name = \Norma\Evn::getHost();
			// [ need to cater for `host:port` since some "buggy" SAPI(s) have been known to return the port too, see http://goo.gl/bFrbCO
			$strpos = strpos($host_name, ':');
			if ($strpos !== false) {
				$host_name = substr($host_name, $strpos);
			}
			// ]
			// [ for dynamic verification, replace this chunk with db/file/curl queries
			$reject_request = !array_search($host_name, explode(',', \Norma\Config::get('domain_whitelist')), true);
			// ]
		}
		if ($reject_request) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
			exit('非法的请求域');
		}
	}
}
