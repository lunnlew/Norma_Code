<?php
/**
 * KoalaCMS - A PHP CMS System In Koala FrameWork
 *
 * @package  KoalaCMS
 * @author   LunnLew <lunnlew@gmail.com>
 */

namespace Controller;
use Koala\Server\Controller\Base as ControllerBase;

class Index extends ControllerBase {
	public function index() {
		$response = \Requests::get('https://github.com/timeline.json');
		print_r($response);exit();
		$o = \Koala\OAPI::factory('Baidu\wxhot','','Library');
		echo $o->apply('wxhot');
		exit;
	}
}