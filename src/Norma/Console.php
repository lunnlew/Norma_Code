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
class Console {
	var $args = [];
	var $found_args = [];

	var $errors = [];

	var $version_str = "Console class 1.3 by LunnLew <lunnlew@gmail.com>";

	// this array describes all the fields args array should define
	// In any of these is missing, we sert up this defaults instead
	var $default_fields = array("short" => FALSE, "long" => FALSE, "info" => "--- No description. Complain! ---", "required" => FALSE, "switch" => FALSE, "multi" => FALSE, "param" => array(),

		// DON'T set any of these by hand!
		"set" => FALSE, "valid" => FALSE);

	var $help_command_name = "";
	var $help_short_len = 0;
	var $help_long_len = 0;

	var $page_width = 74;

	function __construct($args = "") {
		if (is_array($args)) {
			$this->_InitSourceArgsArray($args);
		}

		$this->found_args = array();
		$this->errors = array();
	}

	function Parse($argc, $argv) {
		$result = TRUE;

		$this->help_command_name = $argv[0];

		// let's get user args...
		$result = ($result & $this->_GetArgs($argc, $argv));

		// if no errors found, lets check'em...
		$result = ($result & $this->_ValidateArgs());

		return ($result);
	}

	// returns BOOL if the $key was specified...
	function IsOptionSet($key) {
		$result = FALSE;

		if (isset($this->args[$key])) {
			$result = $this->args[$key]['set'];
		}

		return ($result);
	}

	// returns option argument. Default is '', so it's safe
	// to call this function even against $key is a switch
	// not a regular option
	//
	// NOTE: for arguments with 'multi' == TRUE, you will
	// get Array back! See the demo...
	function GetOptionArg($key) {
		$result = "";

		if (isset($this->args[$key])) {
			if ($this->args[$key]['multi']) {
				$result = $this->args[$key]['param'];
			} else {
				$result = $this->args[$key]['param'][0];
			}

		}

		return ($result);
	}

	// returns numer of values assigned to the option. Usually
	// it can be 0 (if no option or it's valueless) or X
	function GetOptionArgCount($key) {
		$result = 0;

		if (isset($this->args[$key])) {
			if (is_array($this->args[$key]['param'])) {
				$result = count($this->args[$key]['param']);
			} else {
				$result = 1;
			}

		}

		return ($result);
	}

	//outputs errors
	function ShowErrors() {
		$cnt = count($this->errors);

		if ($cnt > 0) {
			printf("%d errors found:\n", $cnt);
			foreach ($this->errors AS $error) {
				printf(" %s\n", $error);
			}

		} else {
			printf("No errors found\n");
		}
	}

	// produces usge page, based on $args
	function ShowHelpPage() {
		$fmt = $this->sprintf(" %%-%ds %%-%ds ", ($this->help_short_len + 1), ($this->help_long_len + 1));

		$msg = $this->sprintf("\nUsage: %s -opt=val -switch ...\n" . "\nKnown options and switches are detailed below.\n" . " [R] means the option is required,\n" . " [S] stands for valueless switch, otherwise\n" . " option requires an value,\n" . " [M] means you can use this option as many times,\n" . " as you need,\n" . "\n", $this->help_command_name);

		foreach ($this->args AS $entry) {
			$flags = ($entry['required']) ? "R" : "";
			$flags .= ($entry['switch']) ? "S" : "";
			$flags .= ($entry['multi']) ? "M" : "";
			if ($flags != "") {
				$flags = $this->sprintf("[%s] ", $flags);
			}

			$short = ($entry['short'] !== FALSE) ? ($this->sprintf("-%s", $entry['short'])) : "";
			$long = ($entry['long'] !== FALSE) ? ($this->sprintf("-%s", $entry['long'])) : "";

			$tmp = $this->sprintf($fmt, $short, $long);
			$indent = strlen($tmp);
			$offset = $this->page_width - $indent;

			$desc = $this->sprintf("%s%s", $flags, $entry['info']);

			$msg .= $this->sprintf("%s%s\n", $tmp, mb_substr($desc, 0, $offset));

			// does it fit?
			if (strlen($entry['info']) > $offset) {
				$_fmt = $this->sprintf("%%-%ds%%s\n", $indent);
				$_text = mb_substr($desc, $offset);
				$_lines = explode("\n", wordwrap($_text, $offset));

				foreach ($_lines AS $_line) {
					$msg .= $this->sprintf($_fmt, "", trim($_line));
				}

			}
		}

		$msg .= "\n";
		echo $msg;
	}

	/***************** PRIVATE FUNCTIONS BELOW ***********************/

	// here we check if source array gave by the application
	// is valid. If any filed is missing, we add it with default
	// value. The only fields that have to be specified are
	// eiher 'short' or 'long' (or both). Do NOT specify 'set'
	// or you will be punished by non-working application ;)
	private function _InitSourceArgsArray($args) {
		$this->args = array();

		foreach ($args AS $key => $val) {
			$tmp = $val;

			foreach ($this->default_fields AS $d_key => $d_val) {
				if (isset($tmp[$d_key]) === FALSE) {
					$tmp[$d_key] = $d_val;
				}
			}

			if (($tmp['short'] === FALSE) && ($tmp['long'] === FALSE)) {
				// bad, bad developer!
				printf("*** FATAL: Missing 'short' or 'long' definition for '%s'.\n", $key);
				exit(10);
			}

			if (($tmp['multi'] == TRUE) && ($tmp['switch'] == TRUE)) {
				printf("*** FATAL: '%s' cannot be both 'switch' and 'multi' argument.\n", $key);
				exit(10);
			}

			// some measures for dynamically layouted help page
			if ($tmp['short'] !== FALSE) {
				$this->help_short_len = max($this->help_short_len, strlen($tmp['short']));
			}

			if ($tmp['long'] !== FALSE) {
				$this->help_long_len = max($this->help_long_len, strlen($tmp['long']));
			}

			// arg entry is fine. Load it up
			$this->args[$key] = $tmp;
		}
	}

	// checks if given argumens are known, unique (precheck
	// was made in GetArgs, but we still need to check against
	// non 'multi' arguments given twice
	private function _ValidateArgs() {
		$result = TRUE;

		foreach ($this->args AS $key => $entry) {
			$found = 0;
			$found_as_key = FALSE;

			if ($entry['short'] !== FALSE) {
				if (array_key_exists($entry['short'], $this->found_args)) {
					$found++;
					$found_as_key = $entry['short'];
				}
			}

			if ($entry['long'] !== FALSE) {
				if (array_key_exists($entry['long'], $this->found_args)) {
					$found++;
					$found_as_key = $entry['long'];
				}
			}

			if (($entry["multi"] != TRUE) && (count($entry['param']) > 0)) {
				$this->errors[] = $this->sprintf("Argument '-%s' was already specified.", $entry['long']);
				$result = FALSE;
			}
			// haven't found anything like this yet
			if ($found == 0) {
				if ($entry["required"] == TRUE) {
					$this->errors[] = $this->sprintf("Missing required option '-%s'.", $entry['long']);
					$result = FALSE;
				}
			} else {
				// either short or long keyword was previously found...
				if ($entry["multi"] != TRUE) {
					if ($found == 2) {
						printf("s: %d\n", $entry["multi"]);
						$this->errors[] = $this->sprintf("Argument '-%s' was already specified.", $entry['long']);
						$result = FALSE;
					}
				}

				if ($entry["switch"] === FALSE) {
					if ($this->found_args[$found_as_key]["val"] === FALSE) {
						$this->errors[] = $this->sprintf("Argument '-%s' requires value (i.e. -%s=something).", $found_as_key, $found_as_key);
						$result = FALSE;
					}
				} else {
					if (count($this->found_args[$found_as_key]["val"]) == 0) {
						printf("'%s' '%s'", $this->found_args[$found_as_key]["val"], $entry["long"]);
						$this->errors[] = $this->sprintf("'-%s' is just a switch, and does not require any value.", $found_as_key);
						$result = FALSE;
					}
				}

				// let's put it back...
				$this->args[$key]['set'] = TRUE;
				if ($entry["switch"] == FALSE) {
					$this->args[$key]['param'] = $this->found_args[$found_as_key]['val'];
				}

				// remove it from found args...
				unset($this->found_args[$found_as_key]);
			}
		}

		// let's check if we got any unknown args...
		if (count($this->found_args) > 0) {
			$msg = "Unknown options found: ";
			$comma = "";
			foreach ($this->found_args AS $key => $val) {
				$msg .= $this->sprintf("%s-%s", $comma, $key);
				$comma = ", ";
			}

			$this->errors[] = $msg;

			return (FALSE);
		}

		return ($result);
	}

	// scans user input and builds array of given arguments
	private function _GetArgs($argc, $argv) {
		$result = TRUE;

		if ($argc >= 1) {
			for ($i = 1; $i < $argc; $i++) {
				$valid = TRUE;

				$tmp = explode("=", $argv[$i]);

				if ($tmp[0][0] != '-') {
					$this->errors[] = $this->sprintf("Syntax error. Arguments start with dash (i.e. -%s).", $tmp[0]);
					$result = FALSE;
				}

				$arg_key = mb_substr(str_replace(array(" "), "", $tmp[0]), 1);

				if (strlen($tmp[0]) <= 0) {
					$this->errors[] = $this->sprintf("Bad argument '%s'.", $tmp[0]);
					$valid = $result = FALSE;
				}

				// if( array_key_exists( $arg_key, $this->found_args ) )
				// {
				// $this->errors[] = $this->sprintf("Argument '%s' was already specified.", $tmp[0]);
				// $valid = $result = FALSE;
				// }

				if ($valid) {
					switch (count($tmp)) {
					case 2:
						$arg_val = $tmp[1];
						break;

					case 1:
						$arg_val = FALSE;
						break;

					default:
						unset($tmp[0]);
						$arg_val = implode("=", $tmp);
						break;
					}

					if (!(isset($this->found_args[$arg_key]))) {
						$this->found_args[$arg_key] = array("key" => $arg_key, "val" => array());
					}

					if (!(in_array($arg_val, $this->found_args[$arg_key]['val']))) {
						$this->found_args[$arg_key]['val'][] = $arg_val;
					}

				}
			}
		}

		return ($result);
	}

	//中文编码处理
	public function printf() {
		$args = func_get_args();
		switch (strtoupper(($evn = new \Norma\Evn)->OS())) {
		case 'WIN':
		default:
			$args[0] = iconv('UTF-8', 'gbk', $args[0]);
			break;
		}
		return call_user_func_array('printf', $args);
	}
	//中文编码处理
	public function sprintf() {
		$args = func_get_args();
		switch (strtoupper(($evn = new \Norma\Evn)->OS())) {
		case 'WIN':
		default:
			$args[0] = iconv('UTF-8', 'gbk', $args[0]);
			break;
		}
		return call_user_func_array('sprintf', $args);
	}

	// ond of class
}
