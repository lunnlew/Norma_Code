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
/**
 * 类注册与加载机制实现
 *
 * 支持PSR-4,Composer及自定义的加载方案
 *
 * @author   LunnLew <lunnlew@gmail.com>
 * @version
 * @package  Norma
 * @example https://github.com/lunnlew/Norma_Code/wiki
 */
class Loader {
	/**
	 * 一个由命名空间前缀作为键值,基准目录数组作为键值的关联数组
	 *
	 * @var array
	 */
	protected $prefixes = array();

	/**
	 * 注册一个类加载器
	 *
	 * @return void
	 */
	public function register() {
		spl_autoload_register(array($this, 'loadClass'));
	}

	/**
	 * 为命名空间前缀新增一个基准目录.
	 *
	 * @param string $prefix 命名空间前缀.
	 * @param string $base_dir 使用命名空间前缀的类的目录位置
	 * @param bool $prepend 如果为true，则放置在栈队列首位，将首先搜索
	 * @return void
	 */
	public function addNamespace($prefix, $base_dir, $prepend = false) {
		// 规范命名空间前缀
		$prefix = trim($prefix, '\\') . '\\';

		// 用'/'规范路径尾随分隔符
		$base_dir = rtrim($base_dir, DIRECTORY_SEPARATOR) . '/';

		// 初始化命名空间前缀数组
		if (isset($this->prefixes[$prefix]) === false) {
			$this->prefixes[$prefix] = array();
		}

		// 绑定命名空间前缀对应的基准目录
		if ($prepend) {
			array_unshift($this->prefixes[$prefix], $base_dir);
		} else {
			array_push($this->prefixes[$prefix], $base_dir);
		}
	}

	/**
	 * 根据类名来加载类文件
	 *
	 * @param string $class 类的全名
	 * @return mixed 成功返回映射的文件名,失败返回flase
	 */
	public function loadClass($class) {
		// 当前命名空间
		$prefix = $class;

		// 从后面开始遍历类全名中命名空间名称, 来查找映射的文件名
		while (false !== $pos = strrpos($prefix, '\\')) {

			// 取名空间前缀并包含尾部的分隔符
			$prefix = substr($class, 0, $pos + 1);

			// 其余是相对类名
			$relative_class = substr($class, $pos + 1);

			// 试着利用命名空间前缀和相对类名来加载映射文件
			$mapped_file = $this->loadMappedFile($prefix, $relative_class);
			if ($mapped_file !== false) {
				return $mapped_file;
			}

			// 删除命名空间前缀尾部的分隔符，以便用于下一次strrpos()迭代
			$prefix = rtrim($prefix, '\\');
		}

		// 未找到映射文件
		return false;
	}

	/**
	 * 利用命名空间前缀和相对类名来加载映射文件
	 *
	 * @param string $prefix 命名空间前缀
	 * @param string $relative_class 相对类名
	 * @return mixed Boolean 如果不能加载则返回false,否则返回加载的文件名
	 */
	protected function loadMappedFile($prefix, $relative_class) {
		// 为这个命名空间前缀设置了基准目录数组没?
		if (isset($this->prefixes[$prefix]) === false) {
			return false;
		}

		// 从命名空间前缀的基准目录中搜索文件
		foreach ($this->prefixes[$prefix] as $base_dir) {

			// 用基准目录替代名称前缀,
			// 在相对类名称中用用目录分隔符替代命名空间分隔符,
			// 最后以.php结尾
			$file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

			// 如果存在文件则require
			if ($this->requireFile($file)) {
				return $file;
			}
		}

		// 未找到映射文件
		return false;
	}

	/**
	 * 如果存在文件则require
	 *
	 * @param string $file 要被require的文件
	 * @return bool 如果存在文件则true, 否则false
	 */
	protected function requireFile($file) {
		if (file_exists($file)) {
			require $file;
			return true;
		}
		return false;
	}

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
	public static function model($name = '', $layer = 'model', $appendSuffix = false, $common = 'common') {
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
	public static function controller($name, $layer = 'controller', $appendSuffix = false, $empty = '') {
		if (strpos($name, '/')) {
			list($module, $name) = explode('/', $name);
		} else {
			$module = \Norma\Request::instance()->module();
		}
		$class = self::parseClass($module, $layer, $name, $appendSuffix);
		$class = 'App\Controller\Index';
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
	public static function validate($name = '', $layer = 'validate', $appendSuffix = false, $common = 'common') {
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
	public static function action($url, $vars = [], $layer = 'controller', $appendSuffix = false) {
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
