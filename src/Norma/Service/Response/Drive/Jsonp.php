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
namespace Norma\Service\Response\Drive;
class Jsonp extends \Norma\Service\Response\Base{
   // 输出参数
    protected $options = [
        'var_jsonp_handler'     => 'callback',
        'default_jsonp_handler' => 'jsonpReturn',
        'json_encode_param'     => JSON_UNESCAPED_UNICODE,
    ];

    protected $contentType = 'application/javascript';

    /**
     * 处理数据
     * @access protected
     * @param mixed $data 要处理的数据
     * @return mixed
     */
    public function output()
    {
        //TODO
        //$var_jsonp_handler = Request::instance()->param($this->options['var_jsonp_handler'], "");
        $handler           = !empty($var_jsonp_handler) ? $var_jsonp_handler : $this->options['default_jsonp_handler'];

        $data = json_encode($this->origin_data, $this->options['json_encode_param']);

        if ($data === false) {
            throw new \InvalidArgumentException(json_last_error_msg());
        }

        $data = $handler . '(' . $data . ');';

        if (!headers_sent() && !empty($this->headers)) {
            // 发送状态码
            http_response_code($this->response_code);
            // 发送头部信息
            foreach ($this->headers as $name => $val) {
                header($name . ':' . $val);
            }
        }
        echo $data;

        if (function_exists('fastcgi_finish_request')) {
            // 提高页面响应
            fastcgi_finish_request();
        }
    }

}
