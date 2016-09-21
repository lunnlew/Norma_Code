<?php
return array(
	// +----------------------------------------------------------------------
	// | 应用设置
	// +----------------------------------------------------------------------

	// 应用命名空间
	'app_namespace' => 'App',
	// 应用调试模式
	'app_debug' => true,
	// 应用Trace
	'app_trace' => false,
	// 应用模式状态
	'app_status' => '',
	// 是否支持多模块
	'app_multi_module' => false,
	// 注册的根命名空间
	'root_namespace' => array(),
	// 扩展配置文件
	'extra_config_list' => array('database', 'route', 'validate'),
	// 扩展函数文件
	'extra_file_list' => array('helper'),
	// 默认输出类型
	'default_return_type' => 'html',
	// 默认AJAX 数据返回格式,可选json xml ...
	'default_ajax_return' => 'json',
	// 默认JSONP格式返回的处理方法
	'default_jsonp_handler' => 'jsonpReturn',
	// 默认JSONP处理方法
	'var_jsonp_handler' => 'callback',
	// 默认时区
	'default_timezone' => 'PRC',
	// 是否开启多语言
	'lang_switch_on' => false,
	// 默认全局过滤方法 用逗号分隔多个
	'default_filter' => '',
	// 默认语言
	'default_lang' => 'zh-cn',
	// 是否启用控制器类后缀
	'controller_suffix' => false,

	// +----------------------------------------------------------------------
	// | 安全设置
	// +----------------------------------------------------------------------

	// 是否启用域名白名单
	'enable_domain_whitelist' => false,
	// 域名白名单
	'domain_whitelist' => '127.0.0.1,localhost',

	// +----------------------------------------------------------------------
	// | 模块设置
	// +----------------------------------------------------------------------

	// 默认模块名
	'default_module' => 'Index',
	// 禁止访问模块
	'deny_module_list' => array('common'),
	// 默认控制器名
	'default_controller' => 'Index',
	// 默认操作名
	'default_action' => 'index',
	// 默认验证器
	'default_validate' => '',
	// 默认的空控制器名
	'empty_controller' => 'Error',
	// 操作方法后缀
	'action_suffix' => '',
	// 自动搜索控制器
	'controller_auto_search' => false,

	// +----------------------------------------------------------------------
	// | URL设置
	// +----------------------------------------------------------------------

	// PATHINFO变量名 用于兼容模式
	'var_pathinfo' => 's',
	// 兼容PATH_INFO获取
	'pathinfo_fetch' => array('ORIG_PATH_INFO', 'REDIRECT_PATH_INFO', 'REDIRECT_URL'),
	// pathinfo分隔符
	'pathinfo_depr' => '/',
	// URL伪静态后缀
	'url_html_suffix' => 'html|xml|json|jsonp',
	// URL普通方式参数 用于自动生成
	'url_common_param' => false,
	// URL参数方式 0 按名称成对解析 1 按顺序解析
	'url_param_type' => 0,
	// 是否开启路由
	'url_route_on' => true,
	// 是否强制使用路由
	'url_route_must' => false,
	// 域名部署
	'url_domain_deploy' => false,
	// 域名根，如.thinkphp.cn
	'url_domain_root' => '',
	// 是否自动转换URL中的控制器和操作名
	'url_convert' => true,
	// 默认的访问控制器层
	'url_controller_layer' => 'Controller',
	// 表单请求类型伪装变量
	'var_method' => '_method',

	// +----------------------------------------------------------------------
	// | 模板设置
	// +----------------------------------------------------------------------

	'template' => array(
		// 模板引擎类型 支持 php think 支持扩展
		'type' => 'Think',
		// 模板路径
		'view_path' => '',
		// 模板后缀
		'view_suffix' => 'html',
		// 模板文件名分隔符
		'view_depr' => '/',
		// 模板引擎普通标签开始标记
		'tpl_begin' => '{',
		// 模板引擎普通标签结束标记
		'tpl_end' => '}',
		// 标签库标签开始标记
		'taglib_begin' => '{',
		// 标签库标签结束标记
		'taglib_end' => '}',
	),

	// 视图输出字符串内容替换
	'view_replace_str' => array(),
	// 默认跳转页面对应的模板文件
	'dispatch_success_tmpl' => FRAME_PATH . '/Tpl/dispatch_jump.tpl',
	'dispatch_error_tmpl' => FRAME_PATH . '/Tpl/dispatch_jump.tpl',

	// +----------------------------------------------------------------------
	// | 异常及错误设置
	// +----------------------------------------------------------------------

	// 异常页面的模板文件
	'exception_tmpl' => FRAME_PATH . '/Tpl/norma_exception.tpl',

	// 错误显示信息,非调试模式有效
	'error_message' => '页面错误！请稍后再试～',
	// 显示错误信息
	'show_error_msg' => false,
	// 异常处理handle类 留空使用 \think\exception\Handle
	'exception_handle' => '',

	// +----------------------------------------------------------------------
	// | Trace设置
	// +----------------------------------------------------------------------

	'trace' => array(
		//支持Html Console
		'type' => 'Html',
	),
);
