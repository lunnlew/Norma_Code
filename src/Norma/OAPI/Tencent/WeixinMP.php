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
 *  微信公众平台
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
class WeixinMP extends RequestBase{
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
    public function weixinSign($args, $partnerKey = '', $type = 'md5') {
        ksort($args);
        $string = $this->ToUrlParams($args);
        if (!empty($partnerKey)) {
            $string . "&key=".$partnerKey;
        }
        return $type($string);
    }
    protected function _getPartnerKey(){
        return $this->partnerKey;
    }
}
