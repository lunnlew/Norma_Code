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
namespace Norma\Service\Payment\Adapter\Alipay;

require_once 'lib/alipay_submit.class.php';
require_once 'lib/alipay_notify.class.php';
/**
 * 支付宝即时到账批量退款有密接口适配器
 */
class Refund extends \Norma\Service\Payment\Adapter\Alipay
{
    //接口配置
    public $config = array();
    //请求参数
    public $param = array(
        //固定参数
        "service" => "refund_fastpay_by_platform_pwd",
    );
}
