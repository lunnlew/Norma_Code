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
namespace Norma\Service\Rank\Driver;

use Norma\Service\Rank\Base;

/**
 * 非云计算环境下的Rank驱动
 */
final class LAERank extends Base {
	//建立一个排行榜
	public function create($name, $number, $expire = 0) {
	}
	//设置排行榜某一项的值
	public function set($name, $key, $value) {
	}
	//获得排行榜相关信息
	public function getInfo($name) {
	}
	//清除排行榜
	public function clear($name) {
	}
	//对某项值减并返回排名
	public function decrease($name, $key, $value, $rankReturn = false) {
	}
	//对某项值加并返回排名
	public function increase($name, $key, $value, $rankReturn = false) {
	}
	//删除某项并返回该项的排名
	public function delete($name, $key, $rankReturn = false) {
	}
	//获得所有排行榜
	public function getAllName() {
	}
	//获得排行榜数据
	public function getList($name, $order = false, $offsetFrom = 0, $offsetTo = PHP_INT_MAX) {
	}
	//获得某项的排名与值
	public function get($name, $key) {
	}
}
