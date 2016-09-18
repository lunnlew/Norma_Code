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
namespace Norma\OAPI\Tencent;

use Norma\OAPI\RequestBase as RequestBase;

/**
 *  微信支付
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
class WXPay extends RequestBase{
    protected $partnerKey;
    public function setPartnerKey($partnerKey){
        $this->partnerKey = $partnerKey;
    }
     /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    protected function _getSign()
    {
        $this->access_params['body']= array_filter($this->access_params['body']);
        unset($this->access_params['body']['sign']);
        $result = strtoupper($this->weixinSign($this->access_params['body'],$this->_getPartnerKey(),'md5'));
        return $result;
    }
    protected function _getPartnerKey(){
        return $this->partnerKey;
    }
    //微信支付签名
    //see https://pay.weixin.qq.com/wiki/doc/api/jsapi.php?chapter=4_3
    public function weixinSign($args, $partnerKey = '', $type = 'md5') {
        ksort($args);
        $string = $this->ToUrlParams($args);
        if (!empty($partnerKey)) {
            $string . "&key=".$partnerKey;
        }
        return $type($string);
    }


    //启用双向认证
    protected $bool_two_Way_Authentication = false;
    protected $SSLCertConfig = array();
    public function setTwoWayAuthenticationFlage($bool_two_Way_Authentication){
        $this->bool_two_Way_Authentication = !!$bool_two_Way_Authentication;
    }
    //设置验证证书
    public function setSSLCertConfig($cert_file='apiclient_cert.pem',$key_file='apiclient_key.pem',$rootca='rootca.pem',$cain_path=''){
        $this->SSLCertConfig = array(
            'apiclient_cert'=>$cert_file,
            'apiclient_key'=>$key_file,
            'rootca'=>$rootca,
            'cain_path'=>$cain_path,
            );
    }


    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
          $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
      }
}
