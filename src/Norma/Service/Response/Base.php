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
namespace Norma\Service\Response;
class Base {
	// 原始数据
	protected $origin_data;

	// 当前的contentType
	protected $contentType = 'text/html';

	// 字符集
	protected $charset = 'utf-8';

	//状态
	protected $response_code = 200;

	// header参数
	protected $header = [];

	function __construct($params) {
		$this->origin_data = $params[0];
		$this->response_code = $params[1];
		$this->contentType($this->contentType, $this->charset);
	}
	/**
	 * 设置响应头
	 * @access public
	 * @param string|array $name  参数名
	 * @param string       $value 参数值
	 * @return $this
	 */
	public function header($name, $value = null) {
		if (is_array($name)) {
			$this->header = array_merge($this->header, $name);
		} else {
			$this->header[$name] = $value;
		}
		return $this;
	}
	/**
	 * 输出的参数
	 * @access public
	 * @param mixed $options 输出参数
	 * @return $this
	 */
	public function options($options = []) {
		$this->options = array_merge($this->options, $options);
		return $this;
	}

	/**
	 * 输出数据设置
	 * @access public
	 * @param mixed $data 输出数据
	 * @return $this
	 */
	public function data($data) {
		$this->data = $data;
		return $this;
	}
	/**
	 * 发送HTTP状态
	 * @param integer $code 状态码
	 * @return $this
	 */
	public function code($code) {
		$this->code = $code;
		return $this;
	}

	/**
	 * LastModified
	 * @param string $time
	 * @return $this
	 */
	public function lastModified($time) {
		$this->header['Last-Modified'] = $time;
		return $this;
	}

	/**
	 * Expires
	 * @param string $time
	 * @return $this
	 */
	public function expires($time) {
		$this->header['Expires'] = $time;
		return $this;
	}

	/**
	 * ETag
	 * @param string $eTag
	 * @return $this
	 */
	public function eTag($eTag) {
		$this->header['ETag'] = $eTag;
		return $this;
	}

	/**
	 * 页面缓存控制
	 * @param string $cache 状态码
	 * @return $this
	 */
	public function cacheControl($cache) {
		$this->header['Cache-control'] = $cache;
		return $this;
	}
	/**
	 * 获取头部信息
	 * @param string $name 头部名称
	 * @return mixed
	 */
	public function getHeader($name = '') {
		return !empty($name) ? $this->header[$name] : $this->header;
	}

	/**
	 * 获取原始数据
	 * @return mixed
	 */
	public function getData() {
		return $this->data;
	}

	/**
	 * 获取输出数据
	 * @return mixed
	 */
	public function getContent() {
		if ($this->content == null) {
			$content = $this->output($this->data);

			if (null !== $content && !is_string($content) && !is_numeric($content) && !is_callable([
				$content,
				'__toString',
			])
			) {
				throw new \InvalidArgumentException(sprintf('variable type error： %s', gettype($content)));
			}

			$this->content = (string) $content;
		}
		return $this->content;
	}

	/**
	 * 获取状态码
	 * @return integer
	 */
	public function getCode() {
		return $this->code;
	}
	/**
	 * 页面输出类型
	 * @param string $contentType 输出类型
	 * @param string $charset     输出编码
	 * @return $this
	 */
	public function contentType($contentType, $charset = 'utf-8') {
		$this->headers['Content-Type'] = $contentType . '; charset=' . $charset;
		return $this;
	}

	public function output() {

		if (!headers_sent() && !empty($this->header)) {
			// 发送状态码
			http_response_code($this->response_code);
			// 发送头部信息
			foreach ($this->header as $name => $val) {
				header($name . ':' . $val);
			}
		}
		echo $this->origin_data;

		if (function_exists('fastcgi_finish_request')) {
			// 提高页面响应
			fastcgi_finish_request();
		}
	}
}
