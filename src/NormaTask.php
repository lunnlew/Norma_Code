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

/**
 * WEB方式核心初始化实现类
 */
class NormaTask extends Singleton
{
    /**
     * 执行应用
     * 若应用没有实现子类execute,则使用该默认方法
     * @static
     * @access public
     */
    public static function execute($type = '')
    {
        $type = ucfirst($type);
        if (!in_array($type, array('Web', 'Cmd'))) {
            $type = 'Web';
        }
        hookTrigger($type . 'Execute', '', '', true);
    }
}

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

/**
 * 内核初始化进程
 */
NormaTask::initialize(function () {
    //框架类库加载方案
    AutoloaderClassPsr4::initialize(function ($instance) {
        $instance->register();
        $instance->addNamespace('Norma', FRAME_PATH);
        require('Core/Func/Common.php');
        require('Core/Func/Special.php');
    });
    //框架类库加载方案
    AutoloaderClassPsr0::initialize(function ($instance) {
        $instance->register();
        $instance->registerNamespaces(array(
            'Advice' => FRAME_PATH . 'Addons',
            'Func' => FRAME_PATH . 'Core',
            'Helper' => FRAME_PATH,
            'Addons' => FRAME_PATH,
            'Base' => FRAME_PATH . 'Core',
            'Requests' => FRAME_PATH . 'Core',
            'Core' => FRAME_PATH,
            'Render' => FRAME_PATH,
            'Server' => FRAME_PATH,
        ));
        $instance->registerDirs(array(
            FRAME_PATH,
        ));
    });
    //插件支持
    \Norma\PluginManager::loadPlugin(FRAME_PATH . 'Plugin');
});
////核心初始化结束
