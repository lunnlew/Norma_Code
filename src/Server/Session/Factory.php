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
namespace Norma\Server\Session;

class Factory extends \Norma\Server\Factory {
	/**
	 * 获取正式服务名
	 * @param  string $name 服务名
	 * @static
	 * @return string 正式服务名
	 */
	public static function getRealServerName($name, $prex = 'Norma') {
		if (in_array($name, array(
			'PDOStream',
			'MemcacheStream',
		))) {
			return self::getApiName('Session', $name, $prex);
		} else {
			return false;
		}
	}
	/**
	 * 组装完整服务类名
	 *
	 * @param  string $server_name 服务驱动名
	 * @param  string $prex        类名前缀
	 * @access protected
	 * @static
	 * @return string 完整服务驱动类名
	 */
	protected static function getApiName($name, $server_name, $prex = 'Norma') {
		return $prex . '\Server\\' . ucwords($name) . '\Stream\\' . $server_name;
	}
}
