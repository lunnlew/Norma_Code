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
namespace Norma\OAPI;

class RequestBase{
	//api名称
    public $api_name;
    public $api_params;
    public $access_params;
    public function __construct($params = array())
    {
        //获得当前的的实例化类名
        $class = get_called_class();
        //分为文件名及组织分类名
        list($filename, $org) = array_reverse(explode('\\', $class));
        //加载参数设置
        $this->api_params= include FRAME_PATH . 'OAPI' . '/' . $org . '/Api/' . $filename . '.php';

        $this->access_params = $params;

    }
     /**
     * 从URL侧获取数据
     * @param  string $name api名
     * @return mixed  数据结果
     */
    public function apply($name, $params = array())
    {
        $this->api_name = strtolower($name);

        if (isset($this->api_params[$this->api_name])) {
        	$this->makeMergeParams($this->api_params,$this->access_params,$params);
            if (isset($this->api_params[$this->api_name]['url'])) {
                //获取请求方法
                $methods = explode('/', strtoupper($this->api_params[$this->api_name]['method']));
                //判断是否使用跳转方式//只对GET方式
                if (in_array('GET', $methods, true) && isset($this->api_params[$this->api_name]['jump'])) {
                    $this->_jumpUrl($this->api_name, $this->access_params, array_shift($methods));
                } else {
                    //获取数据
                    return $this->_fetchUrl($this->api_name, $this->access_params, array_shift($methods));
                }
            } else {
                 //获取数据
                  return $this->_fetchData($this->api_name, $this->access_params);
            }
        } else {
            return null;
        }
    }

    protected function makeMergeParams($api_params,$construct_params,$params){
    	$access_params = array('uri' => array(), 'header' => array(), 'body' => array());
    	$tmp_access_params = array();
    	$config_params = array_merge($api_params[$this->api_name]['public_params'],$api_params[$this->api_name]['request_params']);
    	foreach ($config_params as $postype => $arr) {
    		if(!empty($arr)){
	    		foreach ($arr as $key => $value) {
	    			list($params_name,$params_value) = explode('|',$value);
	    			$tmp_access_params[$params_name] = $params_value;
	    		}
	    		$access_params[$postype] =  array_merge($tmp_access_params,isset($construct_params[$postype])?$construct_params[$postype]:array(),isset($params[$postype])?$params[$postype]:array());
	    		unset($tmp_access_params);
	    	}
        }
        $this->access_params = $access_params;
        foreach ($this->access_params as $postype => $arr) {
    		if(!empty($arr)){
	    		foreach ($arr as $key => $str) {
	    			$result = $this->_parseStr($key,$str);
	    			$this->access_params[$postype] = array_merge($this->access_params[$postype], $result);
	    		}
	    	}
        }
    }
    /*
		     * 从字符中解析出参数名与参数值
		     * @param  string $name api名
		     * @return array  结果
	*/
    protected function _parseStr($name,$str = ''){
        $result = array();
        $result[$name] = $name;
        if (stripos($str, 'fetch') === 0 || stripos($str, 'get') === 0) {
            $result[$name] = $this->{'_' . $str}($result[$name]);
        } elseif (stripos($str, 'make') === 0) {
            $result[$name] = $this->{'_makeFrom'}($result[$name]);
        } else {
            if (($pos = stripos($str, '@')) === 0) {
                $result[$name] = substr($str, $pos + 1);
                $pos = false;
            } else {
                $result[$name] = $str;
            }
        }
        //返回本次字串的结果
        return $result;
    }
     /*
		     * 组装
		     * @param  arr
		     * @return array 结果
	*/
    protected function _makeHeader($params)
    {
        $header = $params['header'];
        unset($params['header']);
        foreach ($header as $key => $value) {
            $params['header'][] = $key . ': ' . $value;
        }
        if(!isset($params['header'])){
        	$params['header'] = array();
        }
        return $params;
    }
    /*
		     * 组装
		     * @param  arr
		     * @return array 结果
	*/
    protected function _makeBody($params)
    {
        switch (strtoupper($this->api_params[$this->api_name]['body_type'])) {

            case 'XML':
            	$params['body'] = $this->ToXml($params['body']);
            	break;
            case 'JSON':
            default:
                $params['body'] = json_encode($params['body']);
                $params['header'][] = 'Content-Type: application/json';
                break;
        }
 		if(!isset($params['body'])){
        	$params['body'] = '';
        }
        return $params;
    }
    /**
	 * 输出xml字符
	 * @throws WxPayException
	**/
	public function ToXml($params)
	{
		if(!is_array($params) 
			|| count($params) <= 0)
		{
    		exit("数组数据异常！");
    	}
    	
    	$xml = "<xml>";
    	foreach ($params as $key=>$val)
    	{
    		if (is_numeric($val)){
    			$xml.="<".$key.">".$val."</".$key.">";
    		}else{
    			$xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
    		}
        }
        $xml.="</xml>";
        return $xml; 
	}
	
    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
	public function FromXml($xml)
	{	
		if(!$xml){
			exit("xml数据异常！");
		}
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $values = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);		
		return $values;
	}
	
	/**
	 * 格式化参数格式化成url参数
	 */
	public function ToUrlParams($params)
	{
		$buff = "";
		foreach ($params as $k => $v)
		{
			if($k != "sign" && $v != "" && !is_array($v)){
				$buff .= $k . "=" . $v . "&";
			}
		}
		
		$buff = trim($buff, "&");
		return $buff;
	}
     /**
     * url跳转
     * @param string $name   api名
     * @param array  $params url参数
     */
    protected function _jumpUrl($name, $params = array())
    {
        header('Location:' . $this->api_params[$name]['url'] . '?' . http_build_query($params['uri']));
    }
    /**
     * 从url侧获取数据的核心方法
     *
     * 该方法以multipart/form-data方式编码数据
     *
     * @param  string $name   api名
     * @param  array  $params 请求参数
     * @param  string $method 请求方法
     * @return string 结果
     */
    protected function _fetchUrl($name, $params = array(), $method = 'GET')
    {
    	//头部参数
        $params = $this->_makeHeader($params);
        //body消息格式
        if (isset($this->api_params[$this->api_name]['body_type'])) {
            $params = $this->_makeBody($params);
        }

        //有文件字段时，值必须是@开头的绝对路径
        //初始化
        $ch = curl_init();

        //设置超时
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);

		if(isset($this->api_params[$name]['cacert_mode'])&&(bool) $this->api_params[$name]['cacert_mode']){
			//SSL认证启用
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, (bool) $this->api_params[$name]['cacert_mode']);
            //cacert_mode 对(域名或子域名)  1仅存在  2存在且匹配
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, $this->api_params[$name]['cacert_mode']);
		}else{
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,FALSE);
			curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,FALSE);
		}

		//启用双向认证
		if($this->bool_two_Way_Authentication){
			//==微信服务器验证客户端

            //客户端证书
			curl_setopt($ch,CURLOPT_SSLCERT,$this->SSLCertConfig['apiclient_cert']);
			//客户端密匙
 			curl_setopt($ch,CURLOPT_SSLKEY,$this->SSLCertConfig['apiclient_key']);

 			
 			if(isset($this->SSLCertConfig['cain_path'])&&!empty($this->SSLCertConfig['cain_path'])){
 				curl_setopt($ch,CURLOPT_CAPATH,$this->SSLCertConfig['cain_path']); 
 			}

 			//==客户端验证微信服务器
 			//微信服务器根域证书
			//根证书可选，该文件为签署微信支付证书的权威机构的根证书，某些环境和工具已经内置了该权威机构的根证书，无需引用该证书也可以正常进行验证
			if(!empty($this->SSLCertConfig['rootca']))
				curl_setopt($ch,CURLOPT_CAINFO,$this->SSLCertConfig['rootca']); 
		}


        curl_setopt($ch, CURLOPT_HTTPHEADER, $params['header']);

        if ($method == 'POST') {
            curl_setopt($ch, CURLOPT_URL, $this->api_params[$name]['url'] . '?' . http_build_query($params['uri']));
            // post方式
            curl_setopt($ch, CURLOPT_POST, 1);
            // post的变量
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params['body']);
        } else {
            curl_setopt($ch, CURLOPT_URL, $this->api_params[$name]['url'] . '?' . http_build_query($params['uri']));
        }
        //以返回值方式
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        // 过滤HTTP头
        curl_setopt($ch, CURLOPT_HEADER, 0);

        //追踪请求内容
       // curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        

        //执行并获取HTML文档内容
        $output = curl_exec($ch);
		
		//获取执行请求后相关信息
		//$info = curl_getinfo($ch,CURLINFO_HEADER_OUT);
		//print_r($output);//打印信息数组

        //返回结果
		if($output){
			curl_close($ch);
			return $output;
		} else { 
			$error = curl_errno($ch);
			curl_close($ch);
			exit("curl出错，错误码:$error");
		}
    }
    public function __call($method, $args)
    {
        return rand();
    }
}