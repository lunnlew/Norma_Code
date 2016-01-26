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
namespace Norma\OAPI\Qiniu;

use Norma\OAPI\BaseV1 as RequestBase;

/**
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Img extends RequestBase
{
    /**
     * [setPutPolicy description]
     * @param string $name      [description]
     * @param array  $putPolicy [description]
     */
    public function setPutPolicy($name, $putPolicy = array())
    {
        $this->_parsePutPolicy($name, $putPolicy);
    }
    /**
     * 从配置中解析出header参数
     * @param  string $name api名
     * @return array  结果
     */
    protected function _parsePutPolicy($name, $putPolicy = array())
    {
        $params = array();
        $paramCFG = $this->cfg[$name]['putPolicy'];
        foreach ($paramCFG as $key => $value) {
            $params = array_merge($params, $this->_parseStr($value));
        }
        $this->cfg[$name]['putPolicy'] = array_merge(array_filter($params), $putPolicy);
    }
    /**
     * [_getAccessKey description]
     * @param  string $str [description]
     * @return string [description]
     */
    abstract protected function _getAccessKey($str);
    /**
     * [_getSecertKey description]
     * @param  string $str [description]
     * @return string [description]
     */
    abstract protected function _getSecertKey($str);
    /**
     *
     * @param  array  $putPolicy [description]
     * @return string [description]
     */
    protected function _getAccessToken($str)
    {
        $encodedPutPolicy = \urlsafe_base64_encode(json_encode($this->cfg[$this->name]['putPolicy']));

        return $this->_getAccessKey('AccessKey')
        . ':' . \urlsafe_base64_encode(hash_hmac("sha1", $encodedPutPolicy, $this->_getSecertKey('SecertKey'), true))
            . ':' . $encodedPutPolicy;
    }
}
