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
use Norma\Request;

/**
 * 域名白名单检查机制
 * http://stackoverflow.com/questions/1459739/php-serverhttp-host-vs-serverserver-name-am-i-understanding-the-ma/28889208#28889208
 */

class DomainWhitelistCheck {

	public function __construct() {
		\Norma\Hook::set('request_action', array(&$this, 'run'));
	}
	public function run(Request $request) {
		$reject_request = true;
		if (array_key_exists('HTTP_HOST', $_SERVER)) {
			$host_name = \Norma\Evn::getHost();
			// [ need to cater for `host:port` since some "buggy" SAPI(s) have been known to return the port too, see http://goo.gl/bFrbCO
			$strpos = strpos($host_name, ':');
			if ($strpos !== false) {
				$host_name = substr($host_name, $strpos);
			}
			// ]
			$enable_domain_whitelist = \Norma\Config::get('enable_domain_whitelist');
			//如果启用白名单机制
			if ($enable_domain_whitelist) {
				$domain_whitelist = \Norma\Config::get('domain_whitelist');
				//允许的域名
				if (!empty($domain_whitelist)) {
					// [ for dynamic verification, replace this chunk with db/file/curl queries
					$reject_request = (false === array_search($host_name, explode(',', $domain_whitelist), true));
					// ]
				} else {
					$reject_request = false;
				}
			} else {
				$reject_request = false;
			}
		}
		if ($reject_request) {
			header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
			exit('非法的请求域');
		}
	}
}