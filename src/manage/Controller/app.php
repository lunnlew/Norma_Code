<?php

namespace App\Controller;
/**
 *
 */
class app {
	use \Norma\Traits\ViewHelper;
	function __construct() {
		$this->initView();
	}
	function index() {
		$this->assign('list', array());
		$this->assign('sys', array());
		return $this->fetch('index');
	}
}