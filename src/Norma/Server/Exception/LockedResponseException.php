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
 * LockedResponseException
 *
 * Exception used for when a response is attempted to be modified while its locked
 *
 * @uses       RuntimeException
 */
class LockedResponseException extends RuntimeException implements NormaExceptionInterface
{
}
