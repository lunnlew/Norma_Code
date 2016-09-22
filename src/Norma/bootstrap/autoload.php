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
//  加载函数库
require FRAME_PATH . '/functions.php';
// 注册框架类加载器
require FRAME_PATH . '/Support/Traits/LoaderHelper.php';
require __DIR__ . '/Loader.php';

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
\Norma\Config::load(APP_PATH . '/Config/Global.php');

// 平台兼容支持
\Norma\Constant::LoadDefineWith(
	[
		\Norma\Support\Evn::DetectOS(),
		function () {
			\Norma\Support\Evn::DetectEngine();
			if (!empty(\Norma\Support\Evn::$runEngineEx)) {
				\Norma\Constant::LoadDefineWith(
					\Norma\Support\Evn::$runEngineEx,
					FRAME_PATH . '/Compatibility'
				);
			}
			return \Norma\Support\Evn::$runEngine;
		},
		\Norma\Support\Evn::DetectAccessMode(),
	],
	FRAME_PATH . '/Compatibility'
);

// 加载插件
\Norma\Hook::loadPlugin(FRAME_PATH . '/Plugin');