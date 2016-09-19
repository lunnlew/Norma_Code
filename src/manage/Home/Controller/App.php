<?php

namespace app\Home\Controller;
/**
 *
 */
class App {
	use \Norma\Traits\ViewHelper;
	function __construct() {
		$this->initView();
	}
	function detail($appid) {
		$this->assign('list', array());
		$this->assign('sys', array());
		return $this->fetch();
	}
}