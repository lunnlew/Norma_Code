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

namespace Norma\Service\TplEngine;

/**
 * 模板引擎接口
 *
 * @package  Norma
 * @subpackage  Service\TplEngine
 * @author    LunnLew <lunnlew@gmail.com>
 */
interface Face
{
    public function assign($key, $value);
    public function set($key, $value);
    public function get($key);
    public function render($tpl);
    public function display($tpl = '');
}
