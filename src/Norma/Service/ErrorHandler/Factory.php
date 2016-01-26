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

namespace Norma\Service\ErrorHandler;

class Factory
{
	use \Norma\Traits\ServiceFactoryHelper;
	static $service = 'ErrorHandler';
	static $list = array(
            'LAEMonologErrorHandler',
            'LAEErrorHandler',
        );
    
}