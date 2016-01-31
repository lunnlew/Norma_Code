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
// 框架路径
defined('FRAME_PATH') or define('FRAME_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);
// 加载基础文件
require FRAME_PATH . 'base.php';
/**
 * 注册框架类加载器 loader
 */
require FRAME_PATH . 'Loader.php';

// 注册类加载器
($loader = new Loader()) -> register();
// 设置Norma命名空间基准路径
$loader -> addNamespace('Norma', FRAME_PATH);

/**
 * 注册框架类默认composer loader
 */

if (file_exists($file=VENDOR_PATH . 'autoload.php')) {
	require_once ($file);
}

/**
 * 包含编译文件
 */
if (file_exists($compiledPath = APP_PATH . 'cache/compiled.php')) {
	require $compiledPath;
}

Constant::LoadDefineWith([($evn=new Evn)->OS(),$evn->Engine(),$evn->MODE()], FRAME_PATH.'Compatibility');

// 注册错误和异常处理机制
// 环境完备性检测
require FRAME_PATH . 'bootstrap/Integrity.php';

// 加载插件
\Norma\PluginManager::loadPlugin(FRAME_PATH . 'Plugin');

// 框架运行行为设置
// 自动生成
if (APP_AUTO_BUILD) {
	if (is_file($file = APP_PATH . 'build.php')) {
		Build::run(
		include $file);
	} else {
		throw new \Norma\Exception\BuildingException(L('The Building Configure File %s Not Exists!', $file));
	}
}
