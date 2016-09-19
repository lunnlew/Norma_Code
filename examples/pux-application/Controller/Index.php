<?php

namespace App\Controller;
/**
 *
 */
class Index {
	function index() {
		$o = \Norma\Service\Cache::getInstance();
		print_r($o);
	}
}