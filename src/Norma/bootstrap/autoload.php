<?php
//加载函数库
require FRAME_PATH . '/functions.php';
// 注册框架类加载器
require FRAME_PATH . '/Support/Traits/LoaderHelper.php';
require FRAME_PATH . '/Loader.php';

// 注册类加载器
$loader = new \Norma\Loader;
$loader->register();
$loader->addNamespace('Norma', FRAME_PATH);

\Norma\App::$loader = $loader;

// 注册错误和异常处理机制
\Norma\Error::register();

// 加载Composer库
defined('COMPOSER_VENDOR_PATH') and require_once COMPOSER_VENDOR_PATH . '/autoload.php';

// 加载默认全局配置文件
\Norma\Config::load(FRAME_PATH . '/Config/Global-default.php');

// 加载应用配置文件
$cfg = \Norma\Config::load(APP_PATH . '/Config/Global.php');

// 平台兼容支持
\Norma\Constant::LoadDefineWith(
	[
		\Norma\Support\Evn::DetectOS(),
		\Norma\Support\Evn::DetectEngine(),
		\Norma\Support\Evn::DetectAccessMode(),
	],
	FRAME_PATH . '/Compatibility'
);

// 加载插件
\Norma\Hook::loadPlugin(FRAME_PATH . '/Plugin');