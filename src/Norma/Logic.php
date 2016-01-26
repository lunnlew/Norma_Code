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
namespace Norma;

class Logic{
	public function add($name,$callable,$type='filter',$pos='before'){
		$this->{$after}[$name] = array('callable'=>$callable,'type'=>$type);
	}
	public function addFilter($name,$filter,$pos='before'){
		$this->add($name,$filter,'filter',$pos);
		// switch ($pos) {
		// 		case 'after':
		// 			$this->after[$name] = array('callable'=>$filter,'type'=>'filter');
		// 			break;
		// 		case 'before':
		// 		default:
		// 			$this->before[$name] = array('callable'=>$filter,'type'=>'filter');
		// 			break;
		// 	}
	}
	public function addAction($name,$action,$pos='before'){
		$this->add($name,$filter,'action',$pos);
		// switch ($pos) {
		// 		case 'after':
		// 			$this->after[$name] = array('callable'=>$action,'type'=>'action');
		// 			break;
		// 		case 'before':
		// 		default:
		// 			$this->before[$name] = array('callable'=>$action,'type'=>'action');
		// 			break;
		// 	}
	}
	public function execute($name,$params){
		foreach ($this->before[$name] as $filter) {
			switch ($filters['type']) {
				case 'filter':
					call_user_func_array($callable,$params);
					break;
				case 'action':
				default:
					$params = call_user_func_array($callable,$params);
					break;
			}
		}
		$logic = new {$name}();
		$result = $logic->run($params);
		foreach ($this->after[$name] as $filter) {
			switch ($filters['type']) {
				case 'filter':
					call_user_func_array($callable,$result);
					break;
				case 'action':
				default:
					$result = call_user_func_array($callable,$result);
					break;
			}
		}
		return $result;
	}
}