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

namespace Norma\Service\TplEngine;

/**
 * 模板引擎工厂类
 *
 * @package  Norma
 * @subpackage  Service\TplEngine
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory {
	use \Norma\Support\Traits\ServiceFactoryHelper;
	static $service = 'TplEngine';
	static $list = array(
		'Smarty',
		'Twig',
		'Tengine',
	);

}
