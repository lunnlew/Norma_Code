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

//框架核心版本
define("FRAME_VERSION", '1.1');
//框架发布时间
define('FRAME_RELEASE', '20140323');
/**
 * WEB方式核心初始化实现类
 */
class NormaCore extends Singleton
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
        if (!in_array($type, array('Web','Cmd'))) {
            $type = 'Web';
        }
        hookTrigger($type .'Execute', '', '', true);
    }
}

use Whoops\Run;
use Whoops\Handler\PrettyPageHandler;

/**
 * 内核初始化进程
 */
NormaCore::initialize(function () {
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
            'Controller' => APP_PATH,
            'Addons' => APP_PATH
        ));
        $instance->registerDirs(array(
            FRAME_PATH
        ));
    });
    //默认文件
    Config::loadFile(FRAME_PATH . 'Global-default.conf.php');
    //定义应用标识码
    //对多个相同应用情况下的缓存服务提供前缀防止缓存段共用问题;
    define('APP_UUID', strtolower(substr(md5(APP_PATH), 0, 6)));
    //调试及错误设置
    if (C('DEBUGLEVEL', defined('DEBUGLEVEL') ? DEBUGLEVEL : 1)) {
            global $_php_error_global_handler;
            $_php_error_global_handler->turnOff();
        unset($_php_error_global_handler);
            $run = new Run;
            $run->pushHandler(new PrettyPageHandler);
            $run->register();
    } else {
        ini_set("display_errors", "Off");
        $log = Server\Log::factory('monolog');
        Server\ErrorHandler::register('monolog', array($log), function () use ($log) {
            $log->pushHandler(new \Monolog\Handler\ChromePHPHandler(Server\Log::INFO));
             $StreamHandler = Server\StreamHandler::factory(RUN_ENGINE.'StreamHandler',array(
                'Log/' . date('Y-m-d') . "/ERROR.log",
                Server\Log::ERROR,
                true
                ));
            $log->pushHandler($StreamHandler);
        });
    }
        
    //插件支持
    \Norma\PluginManager::loadPlugin(FRAME_PATH . 'Plugin');

    \Norma\PluginManager::loadPlugin(APP_PATH . 'Plugin', '');
});
////核心初始化结束
