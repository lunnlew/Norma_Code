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

// 开始运行时间
define('START_TIME', microtime(true));
// 内存使用
define('START_MEM', memory_get_usage());

//--php版本最低需求
(version_compare(PHP_VERSION, $min_version = "7.0") === -1) and exit('当前PHP运行版本[' . PHP_VERSION . "]低于[" . $min_version . "]!");

// 框架路径
defined('FRAME_PATH') or define('FRAME_PATH', dirname(__DIR__) . DIRECTORY_SEPARATOR);

// 应用目录
defined('APP_PATH') or define('APP_PATH', dirname(__DIR__).'/application/');

// 应用目录
defined('APP_PREFIX') or define('APP_PREFIX', substr(md5(APP_PATH),5,6));

// 注册框架类加载器
require FRAME_PATH . 'Loader.php';

// 注册基础文件
require FRAME_PATH . 'base.php';

// 注册类加载器
($loader = new \Norma\Loader()) -> register();
// 注册命名空间路径
$loader -> addNamespace('Norma', FRAME_PATH);
$loader -> addNamespace('App', APP_PATH);

// 加载Composer库
defined('COMPOSER_VENDOR_PATH') and require_once (COMPOSER_VENDOR_PATH. 'autoload.php');

// 编译文件库
if (file_exists($compiledPath = APP_PATH . 'cache/compiled.php')) {
	require $compiledPath;
}else{
	\Norma\Constant::LoadDefineWith([($evn=new \Norma\Evn)->OS(),$evn->Engine(),$evn->MODE()], FRAME_PATH.'Compatibility');
	// 加载插件
	\Norma\PluginManager::loadPlugin(FRAME_PATH . 'Plugin');
}