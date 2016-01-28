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
	public static function LoadDefineWith($types, $path) {
		if (is_string($types)) {
			$types = explode(',', $types);
		}
		foreach ($types as $type) {
			is_file($file = rtrim($path, '/\\') . '/' . strtolower($type) . '.php') &&
			require $file;
		}
	}

}
