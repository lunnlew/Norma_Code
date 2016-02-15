#!/usr/bin/php -q
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
require __DIR__.'/bootstrap/autoload.php';
Task::Use($argc, $argv)->Running();
class Task {
	static $task_name;
	static $task_class_name;
	static function Use($argc, $argv){
		array_shift($argv);
		static::$task_name = $argv[0];
		static::$task_class_name = '\Norma\Task\\'.static::$task_name;
		return new static::$task_class_name(--$argc, $argv);
	}
}