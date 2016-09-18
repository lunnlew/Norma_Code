<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 微信支付服务端API
 *
 */
$cfg['unifiedorder'] = array(
    //API说明
    'summary' => '统一下单',
    //请求URL
    'url'=>'https://api.mch.weixin.qq.com/pay/unifiedorder',
    //请求方法
    'method'=>'post',
    //公共参数
    'public_params'=>array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array(),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array(
        	'appid|getAppid','mch_id|getMchid','device_info|@','nonce_str|makeNonceStr','body|getBody','detail|@','attach|@','out_trade_no|get_out_trade_no','fee_type|@CNY','total_fee|get_total_fee','spbill_create_ip|get_spbill_create_ip','time_start|@','time_expire|@','goods_tag|@','notify_url|get_notify_url','trade_type|@JSAPI','product_id|@','limit_pay|@','openid|@ss','sign|getSign'
        	)
        ),
    'body_type'=>'xml'
    );

$cfg['get_credential_token'] = array(
    //API说明
    'summary' => 'getticket',
    //请求URL
    'url'=>'https://api.weixin.qq.com/cgi-bin/token',
    //请求方法
    'method'=>'get',
    //公共参数
    'public_params'=>array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array(
        	'grant_type|@client_credential','appid|getAppid','secret|getAppSecret'
        	),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array()
        )
    );

$cfg['get_jsapi_ticket_qy'] = array(
    //API说明
    'summary' => 'getticket',
    //请求URL
    'url'=>'https://qyapi.weixin.qq.com/cgi-bin/get_jsapi_ticket',
    //请求方法
    'method'=>'get',
    //公共参数
    'public_params'=>array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array('secret|getAppSecret'
        	),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array()
        )
    );

$cfg['get_jsapi_ticket'] = array(
    //API说明
    'summary' => 'getticket',
    //请求URL
    'url'=>'https://api.weixin.qq.com/cgi-bin/ticket/getticket',
    //请求方法
    'method'=>'get',
    //公共参数
    'public_params'=>array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array(
        	'access_token|getAccessToken','type|@jsapi'
        	),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array()
        )
    );

//https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_2
$cfg['query_order'] = array(
    //API说明
    'summary' => '查询订单',
    //请求URL
    'url'=>'https://api.mch.weixin.qq.com/pay/orderquery',
    //请求方法
    'method'=>'post',
    //公共参数
    'public_params'=>array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array(),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array('appid|getAppid','mch_id|getMchid','transaction_id|@','out_trade_no|@','nonce_str|@','sign|getSign')
        ),
    'body_type'=>'xml'
    );

//https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_3
$cfg['close_order'] = array(
    //API说明
    'summary' => '关闭订单',
    //请求URL
    'url'=>'https://api.mch.weixin.qq.com/pay/closeorder',
    //请求方法
    'method'=>'post',
    //公共参数
    'public_params'=>array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array(),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array('appid|getAppid','mch_id|getMchid','out_trade_no|@','nonce_str|@','sign|getSign')
        ),
    'body_type'=>'xml'
    );
//https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_4
$cfg['refund'] = array(
    //API说明
    'summary' => '退款',
    //请求URL
    'url'=>'https://api.mch.weixin.qq.com/secapi/pay/refund',
    //请求方法
    'method'=>'post',
    //公共参数
    'public_params'=>array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array(),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array('appid|getAppid','mch_id|getMchid','device_info|@','nonce_str|makeNonceStr','transaction_id|@','out_trade_no|get_out_trade_no','out_refund_no|@','total_fee|get_total_fee','refund_fee|get_refund_fee','refund_fee_type|@CNY','op_user_id|@','sign|getSign')
        ),
    'body_type'=>'xml'
    );
//https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_5
$cfg['query_refund'] = array(
    //API说明
    'summary' => '查询退款',
    //请求URL
    'url'=>'https://api.mch.weixin.qq.com/pay/refundquery',
    //请求方法
    'method'=>'post',
    //公共参数
    'public_params'=>array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array(),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array('appid|getAppid','mch_id|getMchid','device_info|@','nonce_str|makeNonceStr','transaction_id|@','out_trade_no|get_out_trade_no','out_refund_no|@','refund_id|@','sign|getSign')
        ),
    'body_type'=>'xml'
    );
//https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_6
$cfg['downloadbill'] = array(
    //API说明
    'summary' => '下载对账单',
    //请求URL
    'url'=>'https://api.mch.weixin.qq.com/pay/downloadbill',
    //请求方法
    'method'=>'post',
    //公共参数
    'public_params'=>array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array(),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array('appid|getAppid','mch_id|getMchid','device_info|@','nonce_str|makeNonceStr','bill_date|@','bill_type|@','sign|getSign')
        ),
    'body_type'=>'xml'
    );
//https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=9_7
//see unifiedorder params  notify_url
return $cfg;
