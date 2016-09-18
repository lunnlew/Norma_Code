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
namespace Norma\Service\Config\Driver;
class Xml {
	public function parse($config) {
		if (is_file($config)) {
			$content = simplexml_load_file($config);
		} else {
			$content = simplexml_load_string($config);
		}
		$result = (array) $content;
		foreach ($result as $key => $val) {
			if (is_object($val)) {
				$result[$key] = (array) $val;
			}
		}
		return $result;
	}
}
