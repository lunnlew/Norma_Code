<?php
/**
 * Norma - A PHP Framework For Web
 * 
 * 框架基本参数设置
 * 
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */

//站点绝对域名
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

//应用相对URL
$file = substr($_SERVER['PHP_SELF'], 0, stripos($_SERVER['PHP_SELF'], '.php') + 4);
$parts = explode('/', $file);
define('APP_RELATIVE_URL', rtrim($file, array_pop($parts)));

//TODO
define('SITE_RELATIVE_URL', APP_RELATIVE_URL);

//应用
define('APP_URL', SITE_URL);
define('SOURCE_RELATIVE_URL', APP_RELATIVE_URL . 'Source/');

defined('VENDOR_PATH') or define('VENDOR_PATH', dirname(dirname(FRAME_PATH)).'/vendor');
is_file(VENDOR_PATH . 'autoload.php') AND require VENDOR_PATH . 'autoload.php';