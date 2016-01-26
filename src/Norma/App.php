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
 * App执行实现类
 */
class App {
	/**
	 * 执行应用
	 * 若应用没有实现子类execute,则使用该默认方法
	 * @static
	 * @access public
	 */
	public static function execute($type = '') {
		$type = ucfirst($type);
		if (!in_array($type, array('Web', 'Cmd'))) {
			$type = 'Web';
		}
		hookTrigger($type . 'Execute', '', '', true);
	}

}
