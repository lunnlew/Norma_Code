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
		$this->assign('list', array());
		$this->assign('sys', array());
		return $this->fetch('index');
	}
}