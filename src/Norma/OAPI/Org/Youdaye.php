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
namespace Norma\OAPI\Org;

use Norma\OAPI\BaseV1 as RequestBase;

/**
 *https://www.youdaye.com/docs.htm
 */
abstract class Youdaye extends RequestBase
{
    /**
     * 获取appUser
     * @param  string $str [description]
     * @return mixed
     */
    abstract protected function _getAppUser($str = '');
    /**
     * 获取appKey
     * @param  string $str [description]
     * @return mixed
     */
    abstract protected function _getAppKey($str = '');
    /**
     * 获取Sender
     * @param  string $str [description]
     * @return mixed
     */
    abstract protected function _getSender($str = '');
}
