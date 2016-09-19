<?php
return array (
  'app_namespace' => 'app',
  'app_debug' => true,
  'app_trace' => false,
  'app_status' => '',
  'app_multi_module' => true,
  'root_namespace' => 
  array (
  ),
  'extra_config_list' => 
  array (
    0 => 'database',
    1 => 'route',
    2 => 'validate',
  ),
  'extra_file_list' => 
  array (
    0 => 'helper',
  ),
  'default_return_type' => 'html',
  'default_ajax_return' => 'json',
  'default_jsonp_handler' => 'jsonpReturn',
  'var_jsonp_handler' => 'callback',
  'default_timezone' => 'PRC',
  'lang_switch_on' => false,
  'default_filter' => '',
  'default_lang' => 'zh-cn',
  'controller_suffix' => false,
  'enable_domain_whitelist' => false,
  'domain_whitelist' => '127.0.0.1,localhost',
  'default_module' => 'Home',
  'deny_module_list' => 
  array (
    0 => 'common',
  ),
  'default_controller' => 'Index',
  'default_action' => 'index',
  'default_validate' => '',
  'empty_controller' => 'Error',
  'action_suffix' => '',
  'controller_auto_search' => false,
  'var_pathinfo' => 's',
  'pathinfo_fetch' => 
  array (
    0 => 'ORIG_PATH_INFO',
    1 => 'REDIRECT_PATH_INFO',
    2 => 'REDIRECT_URL',
  ),
  'pathinfo_depr' => '/',
  'url_html_suffix' => 'html|xml|json|jsonp',
  'url_common_param' => false,
  'url_param_type' => 0,
  'url_route_on' => true,
  'url_route_must' => false,
  'url_domain_deploy' => false,
  'url_domain_root' => '',
  'url_convert' => true,
  'url_controller_layer' => 'controller',
  'var_method' => '_method',
  'template' => 
  array (
    'type' => 'Think',
    'view_path' => '',
    'view_suffix' => 'html',
    'view_depr' => '/',
    'tpl_begin' => '{',
    'tpl_end' => '}',
    'taglib_begin' => '{',
    'taglib_end' => '}',
  ),
  'view_replace_str' => 
  array (
  ),
  'dispatch_success_tmpl' => 'E:\\Workspace\\Norma_Code\\src/Norma/tpl/dispatch_jump.tpl',
  'dispatch_error_tmpl' => 'E:\\Workspace\\Norma_Code\\src/Norma/tpl/dispatch_jump.tpl',
  'exception_tmpl' => 'E:\\Workspace\\Norma_Code\\src/Norma/tpl/norma_exception.tpl',
  'error_message' => '页面错误！请稍后再试～',
  'show_error_msg' => false,
  'exception_handle' => '',
  'trace' => 
  array (
    'type' => 'Html',
  ),
  'db_provider' => 'Mysql',
  'db_options' => 
  array (
  ),
);