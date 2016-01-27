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
 * Norma 引导文件
 */
// 加载基础文件
require dirname(__DIR__) . '/base.php';
require FRAME_PATH . 'Loader.php';

// 实例化类加载器
$loader = new Loader;

// 注册类加载器
$loader -> register();
// 设置Norma命名空间基准路径
$loader -> addNamespace('Norma', FRAME_PATH);
$composer_loader = VENDOR_PATH . 'autoload.php';
if(is_file($composer_loader))include($composer_loader);
// 注册错误和异常处理机制
// 环境完备性检测
require FRAME_PATH . 'bootstrap/Integrity.php';
// 框架基本参数设置
require FRAME_PATH . 'bootstrap/FrameParams.php';

require_once FRAME_PATH . 'Core/Engine/PreDefine.php';
// 加载引擎资源
require_once FRAME_PATH . 'Core/Engine/' . RUN_ENGINE . '.php';
// 加载插件
\Norma\PluginManager::loadPlugin(FRAME_PATH . 'Plugin');
// 框架运行行为设置
// 自动生成
if (APP_AUTO_BUILD && is_file(APP_PATH . 'build.php')) {
	Build::run(
	include APP_PATH . 'build.php');
}
$loader -> addNamespace('Controller', APP_PATH.'Application/Controller');
hookTrigger('appInitialize', '', '', true);

hookTrigger('coreAfterInitialize', '', '', true);

hookTrigger('appAfterInitialize', '', '', true);
