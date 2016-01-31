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

class Controller {
	/**
	 * 供插件管理器主动加载的入口
	 */
	public function __construct() {
		//你想自动挂接的钩子列表
		\Norma\PluginManager::set('getControllerClass', array(&$this, 'register'));
	}

	/**
	 * 注册控制器加载方法并返回控制器类
	 * @param  array  $options [description]
	 * @return [type] [description]
	 */
	public function register($options = array()) {
		if (\Norma\C('MULTIPLE_GROUP')) {
			list($group, $module, $action) = array_values($options);
			!defined('GROUP_NAME') and define('GROUP_NAME', $group);
			$class = $group . '\Controller\\' . $module;
		} else {
			list($module, $action) = array_values($options);
			if (empty($module))
				$module = 'Index';
			$class = 'Controller\\' . $module;
		}
		!defined('MODULE_NAME') and define('MODULE_NAME', ucwords($module));
		!defined('ACTION_NAME') and define('ACTION_NAME', $action);
		return $class;
	}

}
