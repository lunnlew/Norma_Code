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

namespace Norma\Support\Traits;

Trait ServiceFactoryHelper {
	protected static $tpl = '\Service\%s\Driver\%s';
	/**
	 * 获取正式服务名
	 * @param  string $name 服务名
	 * @static
	 * @return string 正式服务名
	 */
	public static function getRealServiceName($name, $prex = 'Norma') {
		if (in_array($name, self::$list)) {
			return self::getApiName(self::$service, $name, $prex);
		} else {
			throw new \Norma\Exception\UnknownServiceException(\Norma\L('Service Driver Type [%s] Unsupport!', $name));
		}
	}
	/**
	 * 组装完整服务类名
	 *
	 * @access protected
	 * @static
	 * @return string 完整服务驱动类名
	 */
	public static function getApiName($classify, $name, $prex = 'Norma') {
		if (empty($prex)) {
			$prex = 'Norma';
		}
		return vsprintf($prex . self::$tpl, array($classify, $name));
	}
}
