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

namespace Norma\Service\Db;

/**
 * 工厂类
 *
 * @package  Norma
 * @subpackage  Service\Db
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory
{
	use \Norma\Traits\ServiceFactoryHelper;
	static $service = 'Db';
	static $list = array(
            'laemysql',
        );
    
}