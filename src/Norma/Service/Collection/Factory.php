<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Service\Collection;

/**
 * Collection工厂类
 *
 * @package  Norma
 * @subpackage  Service\Collection
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory {
	use \Norma\Support\Traits\ServiceFactoryHelper;
	static $service = 'Collection';
	static $list = array(
		'HeaderDataCollection',
		'ServerDataCollection',
		'ResponseCookieDataCollection',
		'FrontDataCollection',
		'DataCollection',
		'RouteCollection',
	);

}