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
 * 获得配置值
 * @param string $key  配置项
 * @param string $defv 默认值
 */
function C($key, $defv = '', $runtime = false) {
	if (strpos($key, 'Plugin') === 0) {
		list($pre, $name) = explode('\\', $key);
		if (file_exists(APP_ADDONS_PATH . 'Plugin\\' . $name . '\config.php')) {
			return
			require APP_ADDONS_PATH . 'Plugin\\' . $name . '\config.php';
		}
	}
	return \Norma\Config::getItem($key, $defv, $runtime);
}

/**
 * 递归获取数组值
 */
function getValueRec($keys = array(), $arr = array(), &$depth = 0) {
	foreach ($keys as $index => $key) {
		if ($depth == 1) {
			$key = strtolower($key);
		}
		$arr = isset($arr[$key]) ? $arr[$key] : null;
		if ($arr === null) {
			$depth = 0;
			break;
		}
		$depth++;
	}
	$depth = 0;

	return $arr;
}

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $echo 是否输出 默认为true 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @return void|string
 */
function dump($var, $echo = true, $label = null) {
	$label = (null === $label) ? '' : rtrim($label) . ':';
	ob_start();
	var_dump($var);
	$output = ob_get_clean();
	$output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
	if (IS_CLI) {
		$output = PHP_EOL . $label . $output . PHP_EOL;
	} else {
		if (!extension_loaded('xdebug')) {
			$output = htmlspecialchars($output, ENT_QUOTES);
		}
		$output = '<pre>' . $label . $output . '</pre>';
	}
	if ($echo) {
		echo($output);
		return null;
	} else {
		return $output;
	}
}
function L() {
	$args = func_get_args();
	return vsprintf(array_shift($args), $args);
}