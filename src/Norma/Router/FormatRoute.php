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
namespace Norma\Router;
class FormatRoute extends RouteBase {
	//Route
	private $m_route;
	//IDictionary<string, IRouteFormatter>
	private $m_formatters;

	public function __construct(
		string $url,
		$default_routes,
		$formatters,
		$constaint_routes,
		$dataToken_routes,
		$routeHandler) {
		$this->m_formatters = $formatters;
		$this->m_route = new Route(
			$url,
			$defaults,
			$constaints,
			$dataTokens,
			$routeHandler);
	}
	public function GetRouteData($httpContext) {
		$result = $this->m_route->GetRouteData($httpContext);
		if ($result == null) {
			return null;
		}

		$valuesModified = array();
		foreach ($result->Values as $k => $pair) {
			$key = $pair->Key;
			$formatter = null;
			if ($this->m_formatters->TryGetValue($key, $formatter)) {
				$o = '';
				if ($formatter->TryParse($pair->Value, $o)) {
					$valuesModified[$key] = $o;
				} else {
					return null;
				}
			}
		}
		foreach ($valuesModified as $k => $pair) {
			$result->Values[$pair->Key] = $pair->Value;
		}
		return $result;
	}

	public function GetVirtualPath($requestContext, $routeValueDictionary) {
		$routeValues = array();
		foreach ($$routeValueDictionary as $k => $pair) {
			$key = $pair->Key;
			$formatter = null;
			if ($this->m_formatters->TryGetValue($key, $formatter)) {
				$s = '';
				if ($formatter->TryToString($pair->Value, $s)) {
					$routeValues[$key] = $s;
				} else {
					return null;
				}
			} else {
				$routeValues[$key] = $pair->Value;
			}
		}

		return $this->m_route->GetVirtualPath($requestContext, $routeValues);
	}

}