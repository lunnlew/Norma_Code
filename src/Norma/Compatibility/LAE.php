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
defined('RUNTIME_PATH') || define('RUNTIME_PATH', APP_PATH . 'Runtime' . DS);
//--编译目录
defined('COMPILE_PATH') || define('COMPILE_PATH', RUNTIME_PATH . 'Compile' . DS);
//--缓存目录
defined('CACHE_PATH') || define('CACHE_PATH', RUNTIME_PATH . 'Cache' . DS);
//--日志路径
defined('LOG_PATH') || define('LOG_PATH', RUNTIME_PATH . 'Log' . DS);

//临时数据路径
if (OS === 'WIN') {
    //windows
    defined('TMP_PATH') || define('TMP_PATH', 'c:/temp/');
} else {
    //linux
    defined('TMP_PATH') || define('TMP_PATH', '/tmp/');
}

//存储数据路径
defined('STOR_PATH') || define('STOR_PATH', RUNTIME_PATH . 'Storage' . DS);

//其他引用
