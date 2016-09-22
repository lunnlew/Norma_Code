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

	use \Norma\Support\Traits\LoaderHelper;
}
