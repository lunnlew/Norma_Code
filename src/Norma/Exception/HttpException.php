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

class HttpException extends RuntimeException implements NormaExceptionInterface {
	private $statusCode;
	private $headers;

	public function __construct($statusCode, $message = null, \Exception $previous = null, array $headers = [], $code = 0) {
		$this->statusCode = $statusCode;
		$this->headers = $headers;

		parent::__construct($message, $code, $previous);
	}

	public function getStatusCode() {
		return $this->statusCode;
	}

	public function getHeaders() {
		return $this->headers;
	}
}