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
class RegexFormatter implements IRouteFormatter {
	private $Regex;
	function TryParse(string $value, \mixed &$result) {
		$s = '';
		$res = $this->Try($value, $s);
		$result = $s;
		return (bool) $res;
	}
	function TryToString(\mixed $value, string &$result) {
		return $this->Try($value, $result);
	}
	function Try ($value, &$result) {
		$s = $value;
		if ($s != null && $this->Regex->IsMatch($s)) {
			$result = $s;
			return true;
		} else {
			$result = null;
			return false;
		}
	}
}