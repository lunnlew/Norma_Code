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
class Base
{
	// 原始数据
    protected $origin_data;

    // 当前的contentType
    protected $contentType = 'text/html';

    // 字符集
    protected $charset = 'utf-8';

    //状态
    protected $response_code = 200;

    // header参数
    protected $headers = [];

	function __construct($params){
		$this->origin_data = $params[0];
        $this->response_code   = $params[1];
        $this->contentType($this->contentType, $this->charset);
	}
	/**
     * 页面输出类型
     * @param string $contentType 输出类型
     * @param string $charset     输出编码
     * @return $this
     */
    public function contentType($contentType, $charset = 'utf-8')
    {
        $this->headers['Content-Type'] = $contentType . '; charset=' . $charset;
        return $this;
    }

    public function output(){

    	if (!headers_sent() && !empty($this->headers)) {
            // 发送状态码
            http_response_code($this->response_code);
            // 发送头部信息
            foreach ($this->headers as $name => $val) {
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
