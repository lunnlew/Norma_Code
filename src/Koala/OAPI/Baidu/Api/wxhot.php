<?php
/**
 * Koala - A PHP Framework For Web
 *
 * @package  Koala
 * @author   LunnLew <lunnlew@gmail.com>
 */

/**
 * 微信公众平台热门精选数据，支持按时间、随机排序，支持关键词检索。
 *
 * http://apistore.baidu.com/apiworks/servicedetail/632.html
 */
$cfg['wxhot'] = array(
	//API说明
	'summary' => '微信公众平台热门精选数据，支持按时间、随机排序，支持关键词检索。',
	//请求URL
	'url'=>'http://apis.baidu.com/txapi/weixin/wxhot',
	//请求方法
	'method'=>'get',
	//请求参数
	'request_params'=>array(
		//位于URI
		'uri'=>array('num|@10','rand|@1','word|@盗墓笔记','page|@1'),
		//位于Header
		'header'=>array('apikey|getApikey'),
		//位于Body
		'body'=>array()
		),
	//公共参数
	'public_params'=>array(),
	//返回数据类型
	'data_type'=>'JSON'
	);
return $cfg;