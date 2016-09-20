<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace App\Home\Plugin;

class Build {
	public function __construct() {
		\Norma\PluginManager::register('build_app', array(&$this, 'build_app'));
	}

	static $project_path = '';

	public function build_app($project_path, $buildoption = [], $namespace = "app", $suffix = false) {

		self::$project_path = $project_path . '/';

		if (!file_exists(self::$project_path)) {
			mkdir(self::$project_path, 0777, true);
		}
		// 锁定
		$lockfile = self::$project_path . 'build.lock';
		if (is_writable($lockfile)) {
			return;
		} elseif (!(strlen('lock') === file_put_contents($lockfile, 'lock'))) {
			throw new \Norma\Exception('应用目录[' . self::$project_path . ']不可写，目录无法自动生成！<BR>请手动生成项目目录~', 10006);
		}
		foreach ($buildoption as $module => $list) {
			if ('__dir__' == $module) {
				// 创建目录列表
				self::buildDir($list);
			} elseif ('__file__' == $module) {
				// 创建文件列表
				self::buildFile($list);
			} else {
				// 创建模块
				self::module($module, $list, $namespace, $suffix);
			}
		}
		// 解除锁定
		unlink($lockfile);
	}
	/**
	 * 创建目录
	 * @access protected
	 * @param  array $list 目录列表
	 * @return void
	 */
	protected static function buildDir($list) {
		foreach ($list as $dir) {
			if (!is_dir(self::$project_path . $dir)) {
				// 创建目录
				mkdir(self::$project_path . $dir, 0755, true);
			}
		}
	}

	/**
	 * 创建文件
	 * @access protected
	 * @param  array $list 文件列表
	 * @return void
	 */
	protected static function buildFile($list) {
		foreach ($list as $file) {
			if (!is_dir(self::$project_path . dirname($file))) {
				// 创建目录
				mkdir(self::$project_path . dirname($file), 0755, true);
			}
			if (!is_file(self::$project_path . $file)) {
				file_put_contents(self::$project_path . $file, 'php' == pathinfo($file, PATHINFO_EXTENSION) ? "<?php\n" : '');
			}
		}
	}

	/**
	 * 创建模块
	 * @access public
	 * @param  string $module 模块名
	 * @param  array  $list build列表
	 * @param  string $namespace 应用类库命名空间
	 * @param  bool   $suffix 类库后缀
	 * @return void
	 */
	public static function module($module = '', $list = [], $namespace = 'app', $suffix = false) {
		$module = $module ? $module : '';
		if (!is_dir(self::$project_path . $module)) {
			// 创建模块目录
			mkdir(self::$project_path . $module);
		}
		if (basename(self::$project_path . 'runtime') != $module) {
			// 创建模块配置目录
			self::buildDir(['Config/' . $module]);
			// 创建配置文件和公共文件
			self::buildCommon($module);
			// 创建模块的默认页面
			self::buildHello($module, $namespace, $suffix);
		}
		if (empty($list)) {
			// 创建默认的模块目录和文件
			$list = [
				'__file__' => ['config.php', 'common.php'],
				'__dir__' => ['controller', 'model', 'view'],
			];
		}
		// 创建子目录和文件
		foreach ($list as $path => $file) {
			$modulePath = self::$project_path . $module . DIRECTORY_SEPARATOR;
			if ('__dir__' == $path) {
				// 生成子目录
				foreach ($file as $dir) {
					if (!is_dir($modulePath . $dir)) {
						// 创建目录
						mkdir($modulePath . $dir, 0755, true);
					}
				}
			} elseif ('__file__' == $path) {
				// 生成（空白）文件
				foreach ($file as $name) {
					if (!is_file($modulePath . $name)) {
						file_put_contents($modulePath . $name, 'php' == pathinfo($name, PATHINFO_EXTENSION) ? "<?php\n" : '');
					}
				}
			} else {
				// 生成相关MVC文件
				foreach ($file as $val) {
					$val = trim($val);
					$filename = $modulePath . $path . DIRECTORY_SEPARATOR . $val . ($suffix ? ucfirst($path) : '') . '.php';
					$space = $namespace . '\\' . ($module ? $module . '\\' : '') . $path;
					$class = $val . ($suffix ? ucfirst($path) : '');
					switch ($path) {
					case 'controller': // 控制器
						$content = "<?php\nnamespace {$space};\n\nclass {$class}\n{\n\n}";
						break;
					case 'model': // 模型
						$content = "<?php\nnamespace {$space};\n\nuse think\Model;\n\nclass {$class} extends Model\n{\n\n}";
						break;
					case 'view': // 视图
						$filename = $modulePath . $path . DIRECTORY_SEPARATOR . $val . '.html';
						if (!is_dir(dirname($filename))) {
							// 创建目录
							mkdir(dirname($filename), 0755, true);
						}
						$content = '';
						break;
					default:
						// 其他文件
						$content = "<?php\nnamespace {$space};\n\nclass {$class}\n{\n\n}";
					}

					if (!is_file($filename)) {
						file_put_contents($filename, $content);
					}
				}
			}
		}
	}

	/**
	 * 创建模块的欢迎页面
	 * @access public
	 * @param  string $module 模块名
	 * @param  string $namespace 应用类库命名空间
	 * @param  bool   $suffix 类库后缀
	 * @return void
	 */
	protected static function buildHello($module, $namespace, $suffix = false) {
		$filename = self::$project_path . ($module ? $module . DIRECTORY_SEPARATOR : '') . 'controller' . DIRECTORY_SEPARATOR . 'Index' . ($suffix ? 'Controller' : '') . '.php';
		if (!is_file($filename)) {
			$content = file_get_contents(FRAME_PATH . '/tpl' . DIRECTORY_SEPARATOR . 'default_index.tpl');
			$content = str_replace(['{$app}', '{$module}', '{layer}', '{$suffix}'], [$namespace, $module ? $module . '\\' : '', 'controller', $suffix ? 'Controller' : ''], $content);
			if (!is_dir(dirname($filename))) {
				mkdir(dirname($filename), 0755, true);
			}
			file_put_contents($filename, $content);
		}
	}

	/**
	 * 创建模块的公共文件
	 * @access public
	 * @param  string $module 模块名
	 * @return void
	 */
	protected static function buildCommon($module) {
		$filename = self::$project_path . 'Config/' . ($module ? $module . DIRECTORY_SEPARATOR : '') . 'config.php';
		if (!is_file($filename)) {
			file_put_contents($filename, "<?php\n//配置文件\nreturn [\n\n];");
		}
		$filename = self::$project_path . 'Config/' . ($module ? $module . DIRECTORY_SEPARATOR : '') . 'common.php';
		if (!is_file($filename)) {
			file_put_contents($filename, "<?php\n;");
		}
	}
}
