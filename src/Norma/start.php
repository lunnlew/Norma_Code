<?php
// +----------------------------------------------------------------------
// | Norma框架运行入口文件
// +----------------------------------------------------------------------
// | Copyright (c) 2015  All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:  LunnLew <lunnlew@gmail.com>
// +----------------------------------------------------------------------
// 版本信息
define('NORMA_VERSION', '1.0');
define('IS_SECURITY', true);
// 开始运行时间
define('START_TIME', microtime(true));
// 内存使用
define('START_MEM', memory_get_usage());
//--php版本最低需求
//(version_compare(PHP_VERSION, $min_version = "7.0") === -1) and exit('当前PHP运行版本[' . PHP_VERSION . "]低于[" . $min_version . "]!");

// 框架路径
defined('FRAME_PATH') or define('FRAME_PATH', __DIR__ . DIRECTORY_SEPARATOR);

// 应用目录
defined('APP_PATH') or define('APP_PATH', dirname(__DIR__) . '/manage');

// 应用前缀
defined('APP_PREFIX') or define('APP_PREFIX', substr(md5(APP_PATH), 5, 6));

// 应用前缀
defined('APP_UUID') or define('APP_UUID', APP_PREFIX);

// 编译文件库
if (file_exists($compiledPath = APP_PATH . '/cache/compiled.php')) {
	require $compiledPath;
} else {
	//加载函数库
	require FRAME_PATH . '/functions.php';
	// 注册框架类加载器
	require FRAME_PATH . '/Support/Traits/LoaderHelper.php';
	require FRAME_PATH . '/Loader.php';

	// 注册类加载器
	$loader = new \Norma\Loader;
	$loader->register();
	// 注册命名空间路径
	$loader->addNamespace('Norma', FRAME_PATH);
	\Norma\App::$loader = $loader;

	$evn = new \Norma\Evn;
	$evn->OS();
	$evn->Engine();
	$evn->MODE();
	\Norma\App::$evn = $evn;

	// 注册错误和异常处理机制
	\Norma\Error::register();

	// 加载Composer库
	defined('COMPOSER_VENDOR_PATH') and require_once COMPOSER_VENDOR_PATH . '/autoload.php';
	// 加载默认全局配置文件
	\Norma\Config::load(FRAME_PATH . '/Config/Global-default.php');
	// 加载应用配置文件
	$cfg = \Norma\Config::load(APP_PATH . '/Config/Global.php');
	// 平台兼容支持
	\Norma\Constant::LoadDefineWith([OS, RUN_ENGINE, RUN_MODE], FRAME_PATH . '/Compatibility');
	// 加载插件
	\Norma\Hook::loadPlugin(FRAME_PATH . '/Plugin');
}

//如果不处于单元测试
if (strpos($_SERVER['PHP_SELF'], 'phpunit') === false) {
	switch (strtoupper($evn->MODE())) {
	case 'CLI':
		\Norma\Task::Using($argc, $argv)->Running();
		break;
	case 'WEB':
	default:
		\Norma\App::listen(new \Norma\Request); //->send();
		break;
	}
}