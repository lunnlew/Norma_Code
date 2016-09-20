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
define('APP_PATH', dirname(dirname(__FILE__)));

define('FRAME_PATH', dirname(dirname(__DIR__)) . '/Norma');

define('COMPOSER_VENDOR_PATH', dirname(dirname(__DIR__)) . '/vendor');

require_once FRAME_PATH . '/start.php';