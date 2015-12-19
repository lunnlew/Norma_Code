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
 *
 * 框架基本参数设置
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
//框架核心版本
define("FRAME_VERSION", '1.1');
//框架发布时间
define('FRAME_RELEASE', '20140323');

switch (RUN_MODE) {
    case 'WEB':
        //站点绝对域名
        define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);

        //应用相对URL
        $file = substr($_SERVER['PHP_SELF'], 0, stripos($_SERVER['PHP_SELF'], '.php') + 4);
        $parts = explode('/', $file);
        define('APP_RELATIVE_URL', rtrim($file, array_pop($parts)));

        //TODO
        define('SITE_RELATIVE_URL', APP_RELATIVE_URL);

        //应用
        define('APP_URL', SITE_URL);
        define('SOURCE_RELATIVE_URL', APP_RELATIVE_URL . 'Source/');

        //定义应用标识码
        //对多个相同应用情况下的缓存服务提供前缀防止缓存段共用问题;
        define('APP_UUID', strtolower(substr(md5(APP_PATH), 0, 6)));
        break;
    case 'CLI':
        break;
    default:
        # code...
        break;
}
