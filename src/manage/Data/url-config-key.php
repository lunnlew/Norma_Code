<?php
return array( // PATHINFO变量名 用于兼容模式
	'var_pathinfo',
	// 兼容PATH_INFO获取
	'pathinfo_fetch',
	// pathinfo分隔符
	'pathinfo_depr',
	// URL伪静态后缀
	'url_html_suffix',
	// URL普通方式参数 用于自动生成
	'url_common_param',
	// URL参数方式 0 按名称成对解析 1 按顺序解析
	'url_param_type',
	// 是否开启路由
	'url_route_on',
	// 是否强制使用路由
	'url_route_must',
	// 域名部署
	'url_domain_deploy',
	// 域名根，如.thinkphp.cn
	'url_domain_root',
	// 是否自动转换URL中的控制器和操作名
	'url_convert',
	// 默认的访问控制器层
	'url_controller_layer',
	// 表单请求类型伪装变量
	'var_method',
);