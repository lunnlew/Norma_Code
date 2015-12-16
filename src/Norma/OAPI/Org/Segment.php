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
 * 矩网智慧 分词服务
 *http://www.vapsec.com/fenci/
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Segment extends RequestBase
{
    /**
     * 获取token
     * @param  string $str [description]
     * @return mixed
     */
    abstract protected function _getAccessToken($str = '');
}
