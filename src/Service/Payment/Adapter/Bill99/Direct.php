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

namespace Norma\Service\Adapter\Bill99;

require_once 'lib/submit.class.php';
/**
 * 快钱人民币网关支付交易接口适配器
 */
class Direct extends \Norma\Service\Adapter\Bill99
{
    //接口配置
    public $config = array();
    //请求参数
    public $param = array();
}
