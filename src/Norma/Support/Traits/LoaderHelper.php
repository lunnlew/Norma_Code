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

Trait LoaderHelper {
	var $instance = '';
	/**
	 * 实例化（分层）模型
	 * @param string $name         Model名称
	 * @param string $layer        业务层名称
	 * @param bool   $appendSuffix 是否添加类名后缀
	 * @param string $common       公共模块名
	 * @return Object
	 * @throws ClassNotFoundException
	 */
	public static function model($name = '', $layer = 'Model', $appendSuffix = false, $common = 'common') {
		if (isset(self::$instance[$name . $layer])) {
			return self::$instance[$name . $layer];
		}
		if (strpos($name, '/')) {
			list($module, $name) = explode('/', $name, 2);
		} else {
			$module = \Norma\Request::instance()->module();
		}
		$class = self::parseClass($module, $layer, $name, $appendSuffix);
		if (class_exists($class)) {
			$model = new $class();
		} else {
			$class = str_replace('\\' . $module . '\\', '\\' . $common . '\\', $class);
			if (class_exists($class)) {
				$model = new $class();
			} else {
				throw new ClassNotFoundException('class not exists:' . $class, $class);
			}
		}
		self::$instance[$name . $layer] = $model;
		return $model;
	}

	/**
	 * 实例化（分层）控制器 格式：[模块名/]控制器名
	 * @param string $name         资源地址
	 * @param string $layer        控制层名称
	 * @param bool   $appendSuffix 是否添加类名后缀
	 * @param string $empty        空控制器名称
	 * @return Object|false
	 * @throws ClassNotFoundException
	 */
	public static function controller($name, $layer = 'Controller', $appendSuffix = false, $empty = '') {
		if (strpos($name, '/')) {
			list($module, $name) = explode('/', $name);
		} else {
			$module = \Norma\Request::instance()->module();
		}
		$class = self::parseClass($module, $layer, $name, $appendSuffix);
		if (class_exists($class)) {
			return new $class(\Norma\Request::instance());
		} elseif ($empty && class_exists($emptyClass = self::parseClass($module, $layer, $empty, $appendSuffix))) {
			return new $emptyClass(Request::instance());
		}
	}

	/**
	 * 实例化验证类 格式：[模块名/]验证器名
	 * @param string $name         资源地址
	 * @param string $layer        验证层名称
	 * @param bool   $appendSuffix 是否添加类名后缀
	 * @param string $common       公共模块名
	 * @return Object|false
	 * @throws ClassNotFoundException
	 */
	public static function validate($name = '', $layer = 'Validate', $appendSuffix = false, $common = 'common') {
		$name = $name ?: Config::get('default_validate');
		if (empty($name)) {
			return new Validate;
		}

		if (isset(self::$instance[$name . $layer])) {
			return self::$instance[$name . $layer];
		}
		if (strpos($name, '/')) {
			list($module, $name) = explode('/', $name);
		} else {
			$module = \Norma\Request::instance()->module();
		}
		$class = self::parseClass($module, $layer, $name, $appendSuffix);
		if (class_exists($class)) {
			$validate = new $class;
		} else {
			$class = str_replace('\\' . $module . '\\', '\\' . $common . '\\', $class);
			if (class_exists($class)) {
				$validate = new $class;
			} else {
				throw new ClassNotFoundException('class not exists:' . $class, $class);
			}
		}
		self::$instance[$name . $layer] = $validate;
		return $validate;
	}

	/**
	 * 远程调用模块的操作方法 参数格式 [模块/控制器/]操作
	 * @param string       $url          调用地址
	 * @param string|array $vars         调用参数 支持字符串和数组
	 * @param string       $layer        要调用的控制层名称
	 * @param bool         $appendSuffix 是否添加类名后缀
	 * @return mixed
	 */
	public static function action($url, $vars = [], $layer = 'Controller', $appendSuffix = false) {
		$info = pathinfo($url);
		$action = $info['basename'];
		$module = '.' != $info['dirname'] ? $info['dirname'] : \Norma\Request::instance()->controller();
		$class = self::controller($module, $layer, $appendSuffix);
		if ($class) {
			if (is_scalar($vars)) {
				if (strpos($vars, '=')) {
					parse_str($vars, $vars);
				} else {
					$vars = [$vars];
				}
			}
			return \Norma\App::invokeMethod([$class, $action . \Norma\Config::get('action_suffix')], $vars);
		}
	}

	/**
	 * 解析应用类的类名
	 * @param string $module 模块名
	 * @param string $layer  层名 controller model ...
	 * @param string $name   类名
	 * @param bool   $appendSuffix
	 * @return string
	 */
	public static function parseClass($module, $layer, $name, $appendSuffix = false) {
		$name = str_replace(['/', '.'], '\\', $name);
		$array = explode('\\', $name);
		$class = self::parseName(array_pop($array), 1) . (\Norma\App::$suffix || $appendSuffix ? ucfirst($layer) : '');
		$path = $array ? implode('\\', $array) . '\\' : '';
		return \Norma\App::$namespace . '\\' . ($module ? $module . '\\' : '') . $layer . '\\' . $path . $class;
	}

	/**
	 * 字符串命名风格转换
	 * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
	 * @param string  $name 字符串
	 * @param integer $type 转换类型
	 * @return string
	 */
	public static function parseName($name, $type = 0) {
		if ($type) {
			return ucfirst(preg_replace_callback('/_([a-zA-Z])/', function ($match) {
				return strtoupper($match[1]);
			}, $name));
		} else {
			return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
		}
	}
}
