<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * WX公众平台
 */
//由于授权操作安全等级较高，所以在发起授权请求时，微信会对授权链接做正则强匹配校验，如果链接的参数顺序不对，授权页面将无法正常访问

//see http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html
$cfg['get_auth_code'] = array(
    'url'=>'https://open.weixin.qq.com/connect/oauth2/authorize',
    'method'=>'get',
    'jump'=>true,
    'public_params'=> array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array('appid|getAppKey','redirect_uri|getRedirectUri','response_type|@code','scope|@snsapi_userinfo','state|getstate'),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array()
        )
    );
//通过Authorization Code获取Access Token,openid
$cfg['get_access_token'] = array(
    'url'=>'https://api.weixin.qq.com/sns/oauth2/access_token',
    'method'=>'get',
    'public_params'=> array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array('grant_type|@authorization_code','appid|getAppKey','secret|getAppSecret','code|getAuthCode'),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array()
        )
    );
//刷新access_token有效期,获取Access Token,openid
$cfg['refresh_access_token'] = array(
    'url'=>'https://api.weixin.qq.com/sns/oauth2/refresh_token',
    'method'=>'get',
    'public_params'=> array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array('grant_type|@refresh_token','appid|getAppKey','refresh_token|getRefreshToken'),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array()
        )
    );
//检查access_token有效性
$cfg['check_access_token'] = array(
    'url'=>'https://api.weixin.qq.com/sns/auth',
    'method'=>'get',
    'public_params'=> array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array('access_token|getAccessToken','openid|getOpenid'),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array()
        )
    );
//获取用户个人信息（UnionID机制）
$cfg['get_userinfo'] = array(
    'url'=>'https://api.weixin.qq.com/sns/userinfo',
    'method'=>'get',
    'public_params'=> array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array('access_token|getAccessToken','openid|getOpenid'),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array()
        )
    );

//see http://mp.weixin.qq.com/wiki/14/bb5031008f1494a59c6f71fa0f319c66.html
$cfg['get_user_info_UnionID'] = array(
    //API说明
    'summary' => '获取用户基本信息（包括UnionID机制）,开发者可通过OpenID来获取用户基本信息。请使用https协议。',
    //请求URL
    'url'=>'https://api.weixin.qq.com/cgi-bin/user/info',
    //请求方法
    'method'=>'get',
    //公共参数
    'public_params'=>array(),
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array(
            //access_token see get_credential_token
            'access_token|getAccessToken','openid|getOpenid','lang|@zh_CN'
            ),
        //位于Header
        'header'=>array(),
        //位于Body
        'body'=>array()
        )
    );
//get_credential_token
return $cfg;
