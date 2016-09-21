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

namespace Norma\Service\KVDB;

class Factory {
	use \Norma\Support\Traits\ServiceFactoryHelper;
	static $service = 'KVDB';
	static $list = array(
		'SAEKVDB',
		'BaeKVDB',
		'LAEKVDB',
	);

}