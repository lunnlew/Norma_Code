<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\OAPI\Org;

use Norma\OAPI\BaseV1 as RequestBase;

/**
 *https://www.youdaye.com/docs.htm
 */
class youdaye extends RequestBase
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
