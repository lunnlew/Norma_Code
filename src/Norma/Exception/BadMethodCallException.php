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

namespace Norma\Exception;

/**
 * BadMethodCallException
 *
 * 当执行不存在的方法时抛出的异常
 */
class BadMethodCallException extends RuntimeException implements NormaExceptionInterface
{
}
