<?php
namespace Norma\Service\Collection\Drive;

/**
 * RouteCollection
 *
 * @uses        DataCollection
 * @package     Klein\DataCollection
 */
class RouteCollection extends DataCollection {

	/**
	 * Methods
	 */

	/**
	 * Constructor
	 *
	 * @override (doesn't call our parent)
	 * @param array $routes
	 * @access public
	 */
	public function __construct(array $routes = array()) {
		foreach ($routes as $key => $value) {
			$this->set($key, $value);
		}
	}

	/**
	 * Set a cookie
	 *
	 * {@inheritdoc}
	 *
	 * A value may either be a string or a ResponseCookie instance
	 * String values will be converted into a ResponseCookie with
	 * the "name" of the cookie being set from the "key"
	 *
	 * Obviously, the developer is free to organize this collection
	 * however they like, and can be more explicit by passing a more
	 * suggested "$key" as the cookie's "domain" and passing in an
	 * instance of a ResponseCookie as the "$value"
	 *
	 * @see DataCollection::set()
	 * @param  string                       $key   The name of the cookie to set
	 * @param  ResponseCookie|string        $value The value of the cookie to set
	 * @access public
	 * @return ResponseCookieDataCollection
	 */
	public function set($key, $value) {
		if ($value instanceof \Norma\Router\FormatRoute) {
			return parent::set($key, $value);
		}
		return false;
	}
}
