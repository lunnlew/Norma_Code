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
namespace Norma\Service\View;

/**
 * 工厂类
 *
 * @package  Norma
 * @subpackage  Service\Storage
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory {
	use \Norma\Support\Traits\ServiceFactoryHelper;
	static $service = 'View';
	static $list = array(
		'View',
	);

}
