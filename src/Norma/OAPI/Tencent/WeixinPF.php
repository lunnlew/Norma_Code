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

use Norma\OAPI\BaseV1 as RequestBase;

/**
 * 微信公众平台 API
 *
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class WeixinPF extends RequestBase
{
    public function firstVerifyToken()
    {
        if ($this->checkSignature()) {
            exit($this->_getEchostr());
        } else {
            exit(0);
        }
    }
    public function getContent()
    {
        return file_get_contents('php://input', 'r');
    }
    public function checkSignature()
    {
        $tmpArr = array($this->_getAccessToken(), $this->_getTimestamp(), $this->_getNonce());
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode($tmpArr);
        $tmpStr = sha1($tmpStr);
        if ($tmpStr == $this->_getSignature()) {
            return true;
        } else {
            return false;
        }
    }
    protected function _getTimestamp($string = 'timestamp')
    {
        return $_GET[$string];
    }
    protected function _getNonce($string = 'nonce')
    {
        return $_GET[$string];
    }
    protected function _getEchostr($string = 'echostr')
    {
        return $_GET[$string];
    }
    protected function _getSignature($string = 'signature')
    {
        return $_GET[$string];
    }
    abstract protected function _getAccessToken($string);
}
