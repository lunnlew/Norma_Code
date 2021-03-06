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

namespace Norma\Service\Counter\Driver;

use Norma\Service\Counter\Base;

/**
 * BAE环境下的Counter驱动
 */
final class BAECounter extends Base {
	public $object;
	public function __construct() {
		$this->object = new \BaeCounter();
	}
	//建立一个计数器
	public function create($name, $value, $expires = '') {
		constant(\BaeCounter::EXPIRES, $expires);

		return $this->object->register($name);
	}
	//移除一个计数器
	public function remove($name) {
		return $this->object->remove($name);
	}
	//获得某项的值
	public function get($name) {
		return $this->object->get($name);
	}
	//设置计数器的值
	public function set($name, $value = 1) {
		return $this->object->set($name, $value);
	}
	//获得多项计数器的值
	public function mget($list) {
		$result = array();
		foreach ($list as $name) {
			$result[] = array($name => $this->object->get($name));
		}

		return $result;
	}
	//设置多个计数器的值
	public function mset($keys) {
		$num = 0;
		foreach ($keys as $name => $value) {
			$this->object->set($name, $value);
			++$num;
		}

		return $num;
	}
	//对计数器减
	public function decrease($name, $value = 1) {
		return $this->object->decrease($name, $value);
	}
	//对计数器加
	public function increase($name, $value = 1) {
		return $this->object->increase($name, $value);
	}
	//获得计数器列表
	public function getAllList() {
		return $this->object->getList();
	}
	//判断计数器是否存在
	public function isExist($name) {
		return $this->object->isExist($name);
	}
	//获得计数器数量
	public function getNums() {
		$list = $this->object->getList();

		return count($list);
	}
}
