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

namespace Norma\Service\Counter\Driver;

use Norma\Service\Counter\Base;

/**
 * SAE环境下的Channel驱动
 */
final class SaeChannel extends Base {
	//云服务对象
	public $object;
	public function __construct() {
		$this->object = new \SaeChannel();
	}
	public function createChannel($channel, $duration = 3600) {
	}
	public function sendMessage($channel, $content) {
	}
}
