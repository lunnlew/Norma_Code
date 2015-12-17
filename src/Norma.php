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
namespace Norma;

//应用版本
defined('APP_VERSION') or define('APP_VERSION', '1');

defined('CONTRLLER_PATH') or define('CONTRLLER_PATH', APP_PATH . 'Application/Controller/');
defined('MODEL_PATH') or define('MODEL_PATH', APP_PATH . 'Application/Model/');
defined('VIEW_PATH') or define('VIEW_PATH', APP_PATH . 'Application/View/');
/**
 * 应用的初始化过程
 */
hookTrigger('appInitialize', '', '', true);
hookTrigger('coreLazyInitialize', '', '', true);
hookTrigger('appLazyInitialize', '', '', true);
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
/**
 * 应用执行实现
 */
class Norma extends NormaCore
{
}
