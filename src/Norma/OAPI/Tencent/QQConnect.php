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
 * QQ OAUTH API
 *
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class QQConnect extends RequestBase
{
    /**
     * 获取code
     * @param  string $str [description]
     * @return mixed
     */
    protected function _getAuthCode($str = '')
    {
        return $_GET['code'];
    }
    /**
     * 获取已保存的code RedirectUri
     * @param  string $str [description]
     * @return mixed
     */
    abstract protected function _getCodeRedirectUri($str = '');
    /**
     * 获取已保存的appid
     * @param  string $str [description]
     * @return mixed
     */
    abstract protected function _getAppKey($str = '');
    /**
     * 获取已保存的appkey
     * @param  string $str [description]
     * @return mixed
     */
    abstract protected function _getAppSecret($str = '');
    /**
     * 获取已保存的openid
     * @param  string $str [description]
     * @return mixed
     */
    abstract protected function _getOpenid($str = '');
    /**
     * 获取已保存的Token值
     * @param  string $str [description]
     * @return mixed
     */
    abstract protected function _getAccessToken($str = '');
}
