<?php
// +----------------------------------------------------------------------
// | 框架管理应用入口文件
// +----------------------------------------------------------------------
// | Copyright (c) 2015  All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author:  LunnLew <lunnlew@gmail.com>
// +----------------------------------------------------------------------
//
//建议使用 SRC_PATH/manage/public 目录作为正式入口
//该文件只是为了方便第一次安装使用框架
//

define('SRC_PATH', './src');

define('APP_PATH', SRC_PATH . '/manage');

define('FRAME_PATH', SRC_PATH . '/Norma/');

define('COMPOSER_VENDOR_PATH', SRC_PATH . '/vendor/');

require_once FRAME_PATH . '/start.php';