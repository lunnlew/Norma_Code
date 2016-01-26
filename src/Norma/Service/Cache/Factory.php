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

namespace Norma\Service\Cache;

/**
 * 缓存工厂实现
 *
 * @package  Norma\Service\Cache
 * @author    LunnLew <lunnlew@gmail.com>
 * @final
 */
final class Factory
{
	use \Norma\Traits\ServiceFactoryHelper;
	static $service = 'Cache';
	static $list = array(
            'LAEFile',
            'LAEMemcache',
            'LAEMemfile',
            'LAEapc',
            'LAEeaccelerator',
            'LAExcache',
            'SAEMemcache',
        );
    
}