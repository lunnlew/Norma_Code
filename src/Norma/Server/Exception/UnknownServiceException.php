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


namespace Norma\Server\Exception;

/**
 * UnknownServiceException
 *
 * Exception used for when a service was called that doesn't exist
 *
 * @uses       Exception
 * @package    Klein\Exceptions
 */
class UnknownServiceException extends RuntimeException implements NormaExceptionInterface
{
}
