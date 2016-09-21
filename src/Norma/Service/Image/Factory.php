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

namespace Norma\Service\Image;

/**
 * Image Factory
 */
class Factory {
	use \Norma\Support\Traits\ServiceFactoryHelper;
	static $service = 'Image';
	static $list = array(
		'SAEImage',
		'LAEImage',
		'LAEGDImage',
	);

}