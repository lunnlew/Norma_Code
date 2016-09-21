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
namespace Norma\Service\Rank;

class Factory {
	use \Norma\Support\Traits\ServiceFactoryHelper;
	static $service = 'Rank';
	static $list = array(
		'LAERank',
		'SAERank',
		'BAERank',
	);

}