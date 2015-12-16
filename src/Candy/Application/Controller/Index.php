<?php
/**
 * NormaCMS - A PHP CMS System In Norma FrameWork
 *
 * @package  NormaCMS
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Controller;
use Norma\Server\Controller\Base as ControllerBase;

class Index extends ControllerBase {
	public function index() {
		$response = \Requests::get('https://github.com/timeline.json');
		print_r($response);exit();
		$o = \Norma\OAPI::factory('Baidu\wxhot','','Library');
		echo $o->apply('wxhot');
		exit;
	}
}