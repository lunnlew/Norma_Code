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

//版本最低需求
(version_compare(PHP_VERSION, $min_version = "5.6") === -1) and exit('当前PHP运行版本[' . PHP_VERSION . "]低于[" . $min_version . "]!");

// 拒绝标志
define('IS_NORMA', true);

// 开始运行时间
define('START_TIME', microtime(true));

// 内存使用
define('START_MEM', memory_get_usage());

// 框架路径
defined('FRAME_PATH') or define('FRAME_PATH', __DIR__ . DIRECTORY_SEPARATOR);

// 应用目录
defined('APP_PATH') or define('APP_PATH', dirname(__DIR__) . '/manage');

// 应用前缀
defined('APP_UUID') or define('APP_UUID', substr(md5(APP_PATH), 5, 6));

require FRAME_PATH . '/bootstrap/autoload.php';

// 编译文件库
if (file_exists($compiledPath = APP_PATH . '/cache/compiled.php')) {
	require $compiledPath;
}

//如果不处于单元测试
if (strpos($_SERVER['PHP_SELF'], 'phpunit') === false) {
	switch (strtoupper(\Norma\Support\Evn::DetectAccessMode())) {
	case 'CLI':
		\Norma\Task::Using($argc, $argv)->Running();
		break;
	case 'WEB':
	default:
		\Norma\App::listen(new \Norma\Request); //->send();
		break;
	}
}