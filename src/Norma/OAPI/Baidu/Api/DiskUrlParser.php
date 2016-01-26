<?php
//$o = \Norma\OAPI::factory('Baidu\DiskUrlParser');
//		echo $o->apply('get_downlod_url',array(
//			'content'=>$o->apply('get_share_url_content')
//			));
$cfg['get_share_url_content'] = array(
    //API说明
    'summary' => 'get_share_url_content',
    //请求URL
    'url'=>'http://pan.baidu.com/s/1gdCfKEB',
    //请求方法
    'method'=>'get',
    //请求参数
    'request_params'=>array(
        //位于URI
        'uri'=>array(),
        //位于Header
        'header'=>array(
        	'Accept|@text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8',
        	//'Accept-Encoding|@gzip,deflate,sdch',
        	'Accept-Language|@zh-CN,zh;q=0.',
        	'Cache-Control|@max-age=0',
        	'Connection|@keep-alive',
        	'Host|@pan.baidu.com',
        	'Referer|@http://pan.baidu.com/share/home?uk=473178403&view=share',
        	'User-Agent|Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/38.0.2125.122 Safari/537.36 SE 2.X MetaSr 1.0',
        	'cookie|@BAIDUID=8D599E2E4A940901FAF665F3A3FAE489:FG=1; BIDUPSID=8D599E2E4A940901FAF665F3A3FAE489; PSTM=1451306304; PANWEB=1; bdshare_firstime=1451651919625; H_PS_PSSID=18729_1443_7477_18726_18535_18730_18545_15197_11487_18098_18019; Hm_lvt_773fea2ac036979ebb5fcc768d8beb67=1451651770; Hm_lpvt_773fea2ac036979ebb5fcc768d8beb67=1451660095; Hm_lvt_adf736c22cd6bcc36a1d27e5af30949e=1451651770; Hm_lpvt_adf736c22cd6bcc36a1d27e5af30949e=1451660095; Hm_lvt_7a3960b6f067eb0085b7f96ff5e660b0=1451651920; Hm_lpvt_7a3960b6f067eb0085b7f96ff5e660b0=1451663602'
        	),
        //位于Body
        'body'=>array()
        ),
    //公共参数
    'public_params'=>array()
    );
$cfg['get_downlod_url'] = array(
    //API说明
    'summary' => 'get_downlod_url',
    //请求参数
    'params_call'=>array(
        'content'=>'clear'
        )
    );
return $cfg;
