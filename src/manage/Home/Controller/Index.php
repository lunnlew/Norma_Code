<?php

namespace app\Home\Controller;
/**
 *
 */
class Index {
	use \Norma\Support\Traits\ViewHelper;
	function __construct() {
		$this->initView();
	}
	function index() {
		$path = (\Norma\Config::get('build.project_path') ?: dirname(dirname(FRAME_PATH)) . '/project') . '/';
		$app = [];
		$handle = opendir($path);
		if ($handle) {
			while ($file = readdir($handle)) {
				if ($file == '.' || $file == '..') {
					continue;
				}
				$newpath = $path . $file;
				if (is_dir($newpath)) {
					$app[] = basename($newpath);
				}
			}
		}
		$this->assign('list', $app);
		return $this->fetch('index');
	}
}