<?php
/* *
 * 功能：支付宝服务器异步通知页面
 * 版本：3.3
 * 日期：2012-07-23
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究支付宝接口使用，只是提供一个参考。

 *************************页面功能说明*************************
 * 创建该页面文件时，请留心该页面文件中无任何HTML代码及空格。
 * 该页面不能在本机电脑测试，请到服务器上做测试。请确保外部可以访问该页面。
 * 该页面调试工具请使用写文本函数logResult，该函数已被默认关闭，见alipay_notify_class.php中的函数verifyNotify
 * 如果没有收到该页面返回的 success 信息，支付宝会在24小时内按一定的时间策略重发通知

 * 如何判断该笔交易是通过即时到帐方式付款还是通过担保交易方式付款？
 *
 * 担保交易的交易状态变化顺序是：等待买家付款→买家已付款，等待卖家发货→卖家已发货，等待买家收货→买家已收货，交易完成
 * 即时到帐的交易状态变化顺序是：等待买家付款→交易完成
 *
 * 每当收到支付宝发来通知时，就可以获取到这笔交易的交易状态，并且商户需要利用商户订单号查询商户网站的订单数据，
 * 得到这笔订单在商户网站中的状态是什么，把商户网站中的订单状态与从支付宝通知中获取到的状态来做对比。
 * 如果商户网站中目前的状态是等待买家付款，而从支付宝通知获取来的状态是买家已付款，等待卖家发货，那么这笔交易买家是用担保交易方式付款的
 * 如果商户网站中目前的状态是等待买家付款，而从支付宝通知获取来的状态是交易完成，那么这笔交易买家是用即时到帐方式付款的
 */
$payment = new Server_Payment_Payment();
$pay = $payment->setAdapter("Alipay_Dualfun",array(
        'partner'=>'132313131',//合作身份者id，以2088开头的16位纯数字
        'key'=>'fafssf',//安全检验码，以数字和字母组成的32位字符
        'sign_type'=>strtoupper('MD5'),//签名方式 不需修改
        'input_charset'=>strtolower('utf-8'),//字符编码格式 目前支持 gbk 或 utf-8
        'cacert'=>getcwd().'\\cacert.pem',////ca证书路径地址，用于curl中ssl校验
        'transport'=>'http',//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
        ))
->notifyUrl(function ($instance) {
    //计算得出通知验证结果
    $alipayNotify = new AlipayNotify($instance->config);
    $verify_result = $alipayNotify->verifyNotify();

    if ($verify_result) {//验证成功
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        //请在这里加上商户的业务逻辑程序代

        //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

        //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

        //商户订单号

        $out_trade_no = $_POST['out_trade_no'];

        //支付宝交易号

        $trade_no = $_POST['trade_no'];

        //交易状态
        $trade_status = $_POST['trade_status'];

        if ($_POST['trade_status'] == 'WAIT_BUYER_PAY') {
        //该判断表示买家已在支付宝交易管理中产生了交易记录，但没有付款

            //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

            echo "success";		//请不要修改或删除

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        } elseif ($_POST['trade_status'] == 'WAIT_SELLER_SEND_GOODS') {
        //该判断表示买家已在支付宝交易管理中产生了交易记录且付款成功，但卖家没有发货

            //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

            echo "success";		//请不要修改或删除

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        } elseif ($_POST['trade_status'] == 'WAIT_BUYER_CONFIRM_GOODS') {
        //该判断表示卖家已经发了货，但买家还没有做确认收货的操作

            //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

            echo "success";		//请不要修改或删除

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        } elseif ($_POST['trade_status'] == 'TRADE_FINISHED') {
        //该判断表示买家已经确认收货，这笔交易完成

            //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序

            echo "success";		//请不要修改或删除

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        } else {
            //其他状态判断
            echo "success";

            //调试用，写文本函数记录程序运行情况是否正常
            //logResult ("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }

        //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    } else {
        //验证失败
        echo "fail";

        //调试用，写文本函数记录程序运行情况是否正常
        //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
    }
});
