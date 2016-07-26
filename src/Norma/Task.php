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
class Task {
	static function Using($argc, $argv) {
		//去除脚本名
		array_shift($argv);
		--$argc;

		if (empty($argv)) {
			echo "Missing required tool name!\n";
			echo "Please run command `php start.php -help`,Or run command `php start.php -list`!\n";
			exit(0);
		}
		//使用默认命令帮助
		if (strpos($argv[0], '-') === 0) {
			array_unshift($argv, 'Help');
			++$argc;
			$task_class_name = '\Norma\Task\\Help';
		} else {
			$task_class_name = '\Norma\Task\\' . $argv[0];
		}
		if (class_exists($task_class_name)) {
			return new $task_class_name($argc, $argv);
		} else {
			echo "The tool `{$argv[0]}` not exists!\n";
			echo "Please run command `php start.php -help`,Or run command `php start.php -list`!\n";
			exit(0);
		}

	}
}