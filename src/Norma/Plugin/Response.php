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
namespace Norma\Plugin;

/**
 * Controller实现类
 */

class Response {
	/**
	 * 供插件管理器主动加载的入口
	 */
	public function __construct() {
		\Norma\Hook::set('output', array(&$this, 'output'));
	}
	public function output($res = '', $type = 'html', $code = '200') {
		//最终数据输出
		(new \Norma\Service\Response)->create($res, $type, $code)->output();
	}
}
