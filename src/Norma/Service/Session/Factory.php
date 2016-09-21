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
namespace Norma\Service\Session;

class Factory {
	use \Norma\Support\Traits\ServiceFactoryHelper;
	static $service = 'Session';
	static $list = array(
		'PDOStream',
		'MemcacheStream',
	);
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
		return $prex . '\Service\\' . ucwords($name) . '\Stream\\' . $server_name;
	}

}