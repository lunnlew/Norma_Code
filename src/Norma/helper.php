<?php
if (!function_exists('url')) {
	/**
	 * Url生成
	 * @param string        $url 路由地址
	 * @param string|array  $value 变量
	 * @param bool|string   $suffix 前缀
	 * @param bool|string   $domain 域名
	 * @return string
	 */
	function url($url = '', $vars = '', $suffix = true, $domain = false) {
		return \Norma\Url::build($url, $vars, $suffix, $domain);
	}
}
if (!function_exists('parseName')) {
	/**
	 * 字符串命名风格转换
	 * type 0 将Java风格转换为C的风格 1 将C风格转换为Java的风格
	 * @param string  $name 字符串
	 * @param integer $type 转换类型
	 * @return string
	 */
	function parseName($name, $type = 0) {
		if ($type) {
			return ucfirst(preg_replace_callback('/_([a-zA-Z])/', function ($match) {
				return strtoupper($match[1]);
			}, $name));
		} else {
			return strtolower(trim(preg_replace("/[A-Z]/", "_\\0", $name), "_"));
		}
	}
}