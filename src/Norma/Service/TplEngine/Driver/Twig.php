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

namespace Norma\Service\TplEngine\Driver;

use Norma\Service\TplEngine\Base;

/**
 * Twig引擎驱动
 *
 * @package  Norma
 * @subpackage  Service\TplEngine\Drive
 * @author    LunnLew <lunnlew@gmail.com>
 */
final class Twig extends Base {
	public $object;
	public $vars = array();
	public function __construct($option = array()) {
		foreach ($option as $key => $value) {
			if (is_string($value)) {
				preg_match_all('/(?<=\[)([^\]]*?)(?=\])/', $value, $res);
				foreach ($res[0] as $v) {
					if (defined($v)) {
						$option[$key] = str_replace("[$v]", constant($v), $option[$key]);
					}
				}
			}
		}
		$loader = new \Twig_Loader_Filesystem($option['template_path']);
		unset($option['template_path']);
		if ($option['cache']) {
			$option['cache'] = $option['cache_path'];
			unset($option['cache_path']);
		}
		$plugins = $option['plugins'];
		unset($option['plugins']);
		$this->object = new \Twig_Environment($loader, $option);

		if (isset($plugins)) {
			if (isset($plugins['function'])) {
				foreach ($plugins['function'] as $name => $callable) {
					$this->registerPlugin($name, $callable);
				}
			}
		}
		$this->test();

	}
	public function assign($key, $value) {
		$this->vars[$key] = $value;
	}
	public function display($tpl = '') {
		$template = $this->object->loadTemplate($tpl);
		echo $template->render($this->vars);
	}
	public function render($tpl, $vars = array()) {
		$template = $this->object->loadTemplate($tpl);

		return $template->render($this->vars);
	}
	public function registerPlugin($name, $callable) {
		$this->object->addFilter(new \Twig_SimpleFilter($name, $callable));

	}
	public function __call($method, $args) {
		echo '尚未统一化方法支持,你可以直接使用原生代码。<br>';
	}
	public function test() {
		$this->object->addTokenParser(new \Tag_TokenParser_get());
	}
}
