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

class Constant {
	/**
	 * 加载常量定义文件
	 */
	public static function LoadDefineWith($type, $path) {
		is_file($file = rtrim($path, '/\\') . '/' . strtolower($type) . '.php') &&
		require $file;
	}

}
