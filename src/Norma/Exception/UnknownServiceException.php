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
 * UnknownServiceException
 *
 * 当一个不存在的服务被调用时抛出的异常
 */
class UnknownServiceException extends RuntimeException implements NormaExceptionInterface
{
}
