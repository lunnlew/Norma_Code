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

namespace Norma\Server\TplEngine\Drive;

use Norma\Server\TplEngine\Base;

/**
 * Tengine引擎驱动
 *
 * @package  Norma
 * @subpackage  Server\TplEngine\Drive
 * @author    LunnLew <lunnlew@gmail.com>
 */
final class Tengine extends Base
{
    public $object;
    public function __construct($option = array())
    {
    }
    /**
     * 注册变量
     * @param string $key
     * @param mixed  $value
     */
    public function assign($key, $value)
    {
    }
    /**
     * 模板输出
     * @param string $tpl 模板名
     */
    public function display($tpl = '')
    {
    }
    /**
     * 返回模板
     * @param string $tpl 模板名
     */
    public function fetch($tpl = '')
    {
    }
}
