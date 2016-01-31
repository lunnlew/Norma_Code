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
 * 环境完备性检测
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
ini_set("display_errors", "On");

//--php版本最低需求
(version_compare(PHP_VERSION, $min_version = "5.3") === -1) and exit('当前PHP运行版本[' . PHP_VERSION . "]低于[" . $min_version . "]!");


RUN_MODE === 'WEB' && (file_exists(APP_PATH) or exit('目录[' . APP_PATH . ']不存在!'));
//必须支持的项目
//--目录是否准备完善
file_exists(FRAME_PATH) || exit('目录[' . FRAME_PATH . ']不存在!');
