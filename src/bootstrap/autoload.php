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

//目录分隔符
defined('DS') || define('DS', DIRECTORY_SEPARATOR);
defined('IN_NORMA') || define('IN_NORMA', true);
//默认调试级别设置
defined('DEBUGLEVEL') || define('DEBUGLEVEL', 1);

defined('FRAME_PATH') || define('FRAME_PATH', dirname(__DIR__) . '/');
/*
|--------------------------------------------------------------------------
| Register The Composer Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader
| for our application. We just need to utilize it! We'll require it
| into the script here so that we do not have to worry about the
| loading of any our classes "manually". Feels great to relax.
|
 */
require __DIR__ . '/../../vendor/autoload.php';

require FRAME_PATH . 'AutoloaderClassPsr4.php';

// instantiate the loader
$loader = new \Norma\AutoloaderClassPsr4;

// register the autoloader
$loader->register();

$loader->addNamespace('Norma', FRAME_PATH);
$loader->addNamespace('Norma', __DIR__ . '/../../tests');

//日志处理
require 'php_error.php';
\php_error\reportErrors();

//环境完备性检测
require FRAME_PATH . 'bootstrap/Integrity.php';
//框架基本参数设置
require FRAME_PATH . 'bootstrap/FrameParams.php';

require_once FRAME_PATH . 'Core/Engine/PreDefine.php';
//加载框架核心
if (RUN_MODE === 'CLI') {
    require FRAME_PATH . 'NormaTask.php'; //CLI核心
    define('RUNTIME_PATH', dirname(dirname(__DIR__)) . '/tests/.runtime/');
} else {
    require FRAME_PATH . 'NormaCore.php'; //WEB核心
    //加载应用核心
    if (file_exists(APP_PATH . 'Custom/Norma.php')) {
        require APP_PATH . 'Custom/Norma.php';
    } else {
        require FRAME_PATH . 'NormaEmpty.php'; //加载空核心
    }
}
//加载引擎资源
require_once FRAME_PATH . 'Core/Engine/' . RUN_ENGINE . '.php';
