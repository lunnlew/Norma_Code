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

/**
 * LAE云引擎参数统一化
 *
 */

//运行数据路径
defined('RUNTIME_PATH') || define('RUNTIME_PATH', 'saemc://Runntime' . DIRECTORY_SEPARATOR);
//--编译目录
defined('COMPILE_PATH') || define('COMPILE_PATH', 'saemc://Compile' . DIRECTORY_SEPARATOR);
//--缓存目录
defined('CACHE_PATH') || define('CACHE_PATH', 'saemc://Cache' . DIRECTORY_SEPARATOR);
//--日志路径
defined('LOG_PATH') || define('LOG_PATH', null);

//临时数据路径
defined('TMP_PATH') || define('TMP_PATH', rtrim(SAE_TMP_PATH) . '/');

//存储数据路径
defined('STOR_PATH') || define('STOR_PATH', null);

//其他引用
//--AE私有常量
define('DB_TYPE', 'mysql');
//MYSQL数据库常量
define('DB_HOST_M', SAE_MYSQL_HOST_M); //主库地址 'w.rdc.sae.sina.com.cn'
define('DB_HOST_S', SAE_MYSQL_HOST_S); //从库地址 'r.rdc.sae.sina.com.cn'
define('DB_PORT', SAE_MYSQL_PORT); //数据库端口 3307
define('DB_USER', SAE_MYSQL_USER); //数据库用户名 SAE_ACCESSKEY
define('DB_PASS', SAE_MYSQL_PASS); //数据库密码 SAE_SECRETKEY
define('DB_NAME', SAE_MYSQL_DB); //数据库名 'app_' . $_SERVER['HTTP_APPNAME']
