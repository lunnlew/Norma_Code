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
namespace Norma\Task;
class Help {
	var $args = array(
		"list" => array("short" => "l", "long" => "list", "info" => "列出可用的工具", "switch" => TRUE),
		"ver" => array("short" => "v", "long" => "version", "switch" => TRUE, "info" => "命令版本"),
		"help" => array("short" => "h", "long" => "help", "info" => "Shows this page", "switch" => TRUE));
	var $argc;
	var $argv;
	function __construct($argc, $argv) {
		$this->argc = $argc;
		$this->argv = $argv;
	}

	public function Running() {
		// let's setup the class
		$Console = new \Norma\Console($this->args);

		if ($this->argc == 1) {
			$Console->printf("Type %s -help for details\n", $this->argv[0]);
			exit(0);
		}

		// now, we parse the args
		$result = $Console->Parse($this->argc, $this->argv);
		if ($Console->IsOptionSet("help")) {
			// let's give them a help page
			$Console->ShowHelpPage();
			// and quit. If user want's help s/he don't care errors
			// at this stage, that's why (again) we can act no matter
			// of Parse() result
			exit(0);
		}
		if ($Console->IsOptionSet("ver")) {
			$Console->printf("Class version: %s\n", $Console->version_str);
			exit(0);
		}
		// ok, can we proceed or not?
		if ($result) {
			// green light...
			if ($Console->IsOptionSet("list")) {
				$Console->printf("%d list(s) specifed:\n", $Console->GetOptionArgCount('list'));
				// since 'list' is 'multi' argument, GetOptionArg() returns an array
				// to trawerse. So we go so...
				$list = $Console->GetOptionArg("list");
				foreach ($list AS $key) {
					$Console->printf(" list: '%s'\n", $key);
				}

			}
		} else {
			// oh, we failed. Spit out help page, and list of encountered
			// errors and quit
			$Console->ShowHelpPage();
			$Console->ShowErrors();
			exit();
		}
	}

}
