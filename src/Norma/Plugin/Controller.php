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
	var $default_group = 'Index';
	var $default_module = 'Index';
	var $default_action = 'index';
	/**
	 * 供插件管理器主动加载的入口
	 */
	public function __construct() {
		//你想自动挂接的钩子列表
		if (\Norma\Config::get('MULTIPLE_GROUP')) {
			\Norma\PluginManager::set('getControllerClass', array(&$this, 'registerByMG'));
		} else {
			\Norma\PluginManager::set('getControllerClass', array(&$this, 'register'));
		}

	}

	/**
	 * 注册控制器加载方法并返回控制器类
	 * @param  array  $options [description]
	 * @return [type] [description]
	 */
	public function register($options = array()) {
		$len = count($options);
		$options = array_fill($len, 2 - $len, '');
		list($module, $action) = array_values($options);
		if (empty($module)) {
			$module = $this->default_module;
		}

		if (empty($action)) {
			$action = $this->default_action;
		}

		$class = 'Controller\\' . $module;

		!defined('MODULE_NAME') and define('MODULE_NAME', ucwords($module));
		!defined('ACTION_NAME') and define('ACTION_NAME', $action);
		return $class;
	}
	/**
	 * 注册控制器加载方法并返回控制器类
	 * @param  array  $options [description]
	 * @return [type] [description]
	 */
	public function registerByMG($options = array()) {
		$len = count($options);
		$options = array_fill($len, 3 - $len, '');
		list($group, $module, $action) = array_values($options);
		if (empty($group)) {
			$group = $this->default_group;
		}

		if (empty($module)) {
			$module = $this->default_module;
		}

		if (empty($action)) {
			$action = $this->default_action;
		}

		$class = $group . '\Controller\\' . $module;

		!defined('GROUP_NAME') and define('GROUP_NAME', $group);
		!defined('MODULE_NAME') and define('MODULE_NAME', ucwords($module));
		!defined('ACTION_NAME') and define('ACTION_NAME', $action);
		return $class;
	}
}
