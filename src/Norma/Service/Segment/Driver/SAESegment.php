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
namespace Norma\Service\Segment\Driver;

use Norma\Service\Segment\Base;

/**
 *
 *分词服务
 *
 */
class SAESegment extends Base {
	public $object;
	public function __construct() {
		$this->object = new \SaeSegment();
	}
}
