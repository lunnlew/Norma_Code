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
namespace Norma\OAPI\Baidu;

use Norma\OAPI\BaseV2 as RequestBase;

/**
 * @abstract
 * @author    LunnLew <lunnlew@gmail.com>
 */
abstract class Wxhot extends RequestBase
{
    abstract protected function _getApikey($item);
}
