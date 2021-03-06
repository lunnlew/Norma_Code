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

Trait ServiceHelper {
	/**
	 * 服务驱动实例数组
	 * @var array
	 * @static
	 * @access protected
	 */
	protected static $instances = array();
	/**
	 * 服务工厂类名
	 * @var string
	 * @static
	 * @access protected
	 */
	protected static $fac = null;
	/**
	 * 获取最终服务类实例
	 *
	 * @param $name 服务名
	 * @param $options array 服务参数
	 * @param $default string 服务默认类名
	 * @param $prex string 服务默认类名前缀
	 * @access public
	 */
	public static function getInstance($name = '', $options = array(), $default = 'Service', $prex = 'Norma') {
		$called_class = get_called_class();
		$class_parts = explode('\\', $called_class);
		$server_name = array_pop($class_parts);
		if (empty($name)) {
			$name = \Norma\Config::get($server_name . ':default', strtoupper(\Norma\Support\Evn::$runEngine) . $default);
		}
		if (isset(self::$instances[$name])) {
			return self::$instances[$name];
		}
		self::$fac = $called_class . '\Factory';
		return (self::$instances[$name] = static::getDriveInstance($name, array_merge((Array) \Norma\Config::get($server_name . ':' . $name), (Array) $options), $prex));
	}
	/**
	 * 获取最终服务类实例
	 *
	 * 云引擎环境自动判断类名
	 *
	 * @param $name 服务名
	 * @param $options array 服务参数
	 * @param $default string 服务默认类名
	 * @param $prex string 服务默认类名前缀
	 * @access public
	 */
	public static function getInstanceN($name = '', $options = array(), $default = 'Service', $prex = 'Norma') {
		$called_class = get_called_class();
		$class_parts = explode('\\', $called_class);
		$server_name = array_pop($class_parts);
		if (empty($name)) {
			$name = \Norma\Config::get($server_name . ':default', strtoupper(\Norma\Support\Evn::$runEngine) . $default);
		}
		$name = static::getServiceName($name);
		if (isset(self::$instances[$name])) {
			return self::$instances[$name];
		}
		self::$fac = $called_class . '\Factory';
		return (self::$instances[$name] = static::getDriveInstance($name, array_merge((Array) \Norma\Config::get($server_name . ':' . $name), (Array) $options), $prex));
	}
	/**
	 * 获得服务驱动实例
	 *
	 * @final
	 * @static
	 * @return object 实例
	 */
	protected static function getDriveInstance($class, $options = array(), $prex = 'Norma') {
		$fac = self::$fac;
		$class = $fac::getRealServiceName($class, $prex);
		if (class_exists($class)) {
			return new $class(array_filter($options));
		} else {
			throw new \Norma\Exception\UnknownServiceException(L('Service Drive Class %s Not Exists!', $class));
		}
	}
	/**
	 * 获得服务类名
	 *
	 * 用于云引擎环境自动前置追加前缀的类名
	 *
	 * @final
	 * @static
	 * @return object 实例
	 */
	protected static function getServiceName($name) {
		$name = ucfirst($name);
		if (!in_array(strtoupper(substr($name, 0, 3)), array(
			'LAE', 'BAE', 'SAE',
		))) {
			return strtoupper(\Norma\Support\Evn::$runEngine) . $name;
		} else {
			return $name;
		}
	}
}
