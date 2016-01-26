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

namespace Norma\Service\Channel;

/**
 * Channel工厂类
 *
 * @package  Norma
 * @subpackage  Service\Channel
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory
{
	use \Norma\Traits\ServiceFactoryHelper;
	static $service = 'Channel';
	static $list = array(
            'saechannel',
            'laechannel',
            'baechannel',
        );
    
}