<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Koala\OAPI\Baidu;

use Koala\OAPI\BaseV2 as RequestBase;

/**
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class wxhot extends RequestBase
{
    abstract protected function _getApikey($item);
}
