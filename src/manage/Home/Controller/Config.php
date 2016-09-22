<?php

namespace app\Home\Controller;
/**
 *
 */
class Config {
	use \Norma\Support\Traits\ViewHelper;
	function __construct() {
		$this->initView();
	}
	function detail($appid, $item = 'base') {
		$project_path = (\Norma\Config::get('build.project_path') ?: dirname(dirname(FRAME_PATH)) . '/project') . '/' . $appid;

		$config = include $project_path . '/Config/Global.php';

		if (!is_array($config) || empty($config)) {
			$config = \Norma\Config::get();
		} else {
			$config = array_merge(\Norma\Config::get(), $config);
		}

		switch ($item) {
		case 'error':
			$data = array_intersect_key($config, array_flip(include (APP_PATH . '/Data/error-config-key.php')));
			break;
		case 'template':
			$data = array_intersect_key($config, array_flip(include (APP_PATH . '/Data/template-config-key.php')));
			break;
		case 'url':
			$data = array_intersect_key($config, array_flip(include (APP_PATH . '/Data/url-config-key.php')));
			break;
		case 'module':
			$data = array_intersect_key($config, array_flip(include (APP_PATH . '/Data/module-config-key.php')));
			break;
		case 'base':
		default:
			$data = array_intersect_key($config, array_flip(include (APP_PATH . '/Data/base-config-key.php')));
			break;
		}
		$this->assign('list', $data);
		$this->assign('item_type', $item);
		$this->assign('appid', $appid);
		return $this->fetch();
	}
	function update($pk, $value, $appid, $item = 'base') {
		$project_path = (\Norma\Config::get('build.project_path') ?: dirname(dirname(FRAME_PATH)) . '/project') . '/' . $appid;

		$config = include $project_path . '/Config/Global.php';

		switch ($item) {
		case 'error':
			$data = include APP_PATH . '/Data/error-config-key.php';
			break;
		case 'template':
			$data = include APP_PATH . '/Data/template-config-key.php';
			break;
		case 'url':
			$data = include APP_PATH . '/Data/url-config-key.php';
			break;
		case 'module':
			$data = include APP_PATH . '/Data/module-config-key.php';
			break;
		case 'base':
		default:
			$data = include APP_PATH . '/Data/base-config-key.php';
			break;
		}
		if (in_array($pk, $data)) {
			$config[$pk] = $value;
		}
		file_put_contents($project_path . '/Config/Global.php', "<?php\nreturn " . var_export($config, true) . ";");
		return $pk;
	}
}