<?php
/**
 * 请重命名 该文件为 index.php
 *
 * 然后增加一行代码
 *
 */
//调试级别
define('DEBUGLEVEL', 1);
//目录分隔符
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
defined('IN_KOALA') or define('IN_KOALA', true);

//入口绝对路径
define('ENTRANCE_PATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
//入口相对路径
define('ENTRANCE_RELATIVE_PATH', basename(ENTRANCE_PATH). DIRECTORY_SEPARATOR);

//框架绝对路径
define('FRAME_PATH', dirname(ENTRANCE_PATH) . '/src/koala/');



/**
 * 应用绝对路径
 * 默认在 ENTRANCE_PATH.'MyApp/'处建立目录
 *
 * 请在此处增加一行代码用于定义应用目录路径
 * 可以取消下面语句的注释
 */
define('APP_PATH', ENTRANCE_PATH);

//日志处理
require(FRAME_PATH. 'Initialise/php_error.php');
\php_error\reportErrors();

//环境完备性检测
require FRAME_PATH . 'Initialise/Integrity.php';
//框架基本参数设置
require FRAME_PATH . 'Initialise/FrameParams.php';



//加载框架核心
require FRAME_PATH . 'Core/KoalaCore.php';//WEB核心

require 'Custom/KoalaTest.php';
//执行应用
KoalaTest::execute();