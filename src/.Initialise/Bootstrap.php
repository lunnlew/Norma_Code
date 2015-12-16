<?php
/**
 * Norma - A PHP Framework For Web
 *
 * 应用引导程序
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */

//目录分隔符
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('IN_NORMA') or define('IN_NORMA', true);
//默认调试级别设置
defined('DEBUGLEVEL') or define('DEBUGLEVEL', 1);

//日志处理
require('php_error.php');
\php_error\reportErrors();
//环境完备性检测
require ENTRANCE_RELATIVE_PATH . '.Initialise/Integrity.php';
//框架基本参数设置
require ENTRANCE_RELATIVE_PATH . '.Initialise/FrameParams.php';

//加载框架核心
if (RUN_MODE==='WEB') {
    require FRAME_PATH . 'NormaCore.php';//WEB核心
} else {
    require FRAME_PATH . 'NormaTask.php';//CLI核心
}
//加载引擎资源
require_once(FRAME_PATH . 'Core/Engine/' . RUN_ENGINE . '.php');

//加载应用核心
if (file_exists(APP_PATH . 'Custom/Norma.php')) {
    require APP_PATH . 'Custom/Norma.php';
} else {
    require FRAME_PATH . 'Norma.php';//加载空核心
}
