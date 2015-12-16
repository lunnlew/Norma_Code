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
 * DuplicateServiceException
 *
 * Exception used for when a service is attempted to be registered that already exists
 *
 * @uses       Exception
 * @package    Klein\Exceptions
 */
class DuplicateServiceException extends RuntimeException implements NormaExceptionInterface
{
}
