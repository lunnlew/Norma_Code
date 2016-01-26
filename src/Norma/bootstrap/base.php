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
 * 常量及全局函数定义文件
 */
// ===常量
// 开始运行时间和内存使用
define('START_TIME', microtime(true));
define('START_MEM', memory_get_usage());
// 版本信息
define('NORMA_VERSION', '1.0');

// ===系统常量
// 是否自动生成应用模块
defined('APP_AUTO_BUILD') or define('APP_AUTO_BUILD', false);
// 是否为单元测试
defined('IN_UNIT_TEST') or define('IN_UNIT_TEST', false);
// 目录分隔符
defined('DS') or define('DS', DIRECTORY_SEPARATOR);
// 框架路径
defined('FRAME_PATH') or define('FRAME_PATH', dirname(__FILE__) . DS);

// ===全局函数

/**
 * 触发钩子
 */
function hookTrigger($hook, $param = null, $callable = null, $return = false) {
	return \Norma\PluginManager::trigger($hook, $param, $callable, $return);
}

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
