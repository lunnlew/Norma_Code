<?php

namespace app\Home\Controller;
/**
 *
 */
class App {
	use \Norma\Support\Traits\ViewHelper;
	function __construct() {
		$this->initView();
	}
	function detail($appid) {
		$this->assign('list', array());
		$this->assign('sys', array());
		return $this->fetch();
	}
	function newApp($step = 0) {
		$tpl = '';
		switch ($step) {
		case 0:
		default:
			$tpl = 'new_step0';
			break;
		}
		return $this->fetch($tpl);
	}

	function build($appname = 'app') {
		$project_path = (\Norma\Config::get('build.project_path') ?: dirname(dirname(FRAME_PATH)) . '/project') . '/' . $appname;
		\Norma\PluginManager::trigger('build_app', array(
			'project_path' => $project_path,
			'buildoption' => [
				// 生成运行时目录
				'__dir__' => ['runtime/cache', 'runtime/log', 'runtime/temp', 'runtime/template', 'config'],
				// 生成应用公共文件
				'__file__' => ['common.php', 'config.php', 'database.php'],

				// 定义demo模块的自动生成 （按照实际定义的文件名生成）
				'demo' => [
					'__file__' => ['common.php'],
					'__dir__' => ['behavior', 'controller', 'model', 'view'],
					'controller' => ['Index', 'Test', 'UserType'],
					'model' => ['User', 'UserType'],
					'view' => ['index/index'],
				],
				// 其他更多的模块定义
			]));
		return $this->fetch();
	}
}