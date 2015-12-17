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
namespace Norma\Server\Payment\Adapter\Alipay;

require_once 'lib/alipay_submit.class.php';
require_once 'lib/alipay_notify.class.php';
/**
 * 支付宝即时到账交易接口适配器
 */
class Direct extends \Norma\Server\Payment\Adapter\Alipay
{
    //接口配置
    public $config = array();
    //请求参数
    public $param = array(
        //固定参数
        "service" => "create_direct_pay_by_user",
        "payment_type"  => "1",//支付类型
        );
}
