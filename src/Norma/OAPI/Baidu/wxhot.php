<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\OAPI\Baidu;

use Norma\OAPI\BaseV2 as RequestBase;

/**
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class wxhot extends RequestBase
{
    abstract protected function _getApikey($item);
}
