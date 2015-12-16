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
//加载单例实现
include(__DIR__ . '/Singleton.php');
//加载类加载器
include(__DIR__ . '/ClassLoader.php');
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
    ClassLoader::initialize(function ($instance) {
        $instance->register();
        $instance->registerNamespaces(array(
            'Advice' => FRAME_PATH . 'Plugin',
            'Func' => FRAME_PATH . 'Core',
            'Helper' => FRAME_PATH,
            'Plugin' => FRAME_PATH,
            'Base' => FRAME_PATH . 'Core',
            'Requests' => FRAME_PATH . 'Core',
            'Core' => FRAME_PATH,
            'Render' => FRAME_PATH,
            'Server' => FRAME_PATH,
            'Norma' => dirname(FRAME_PATH),
            'Controller' => APP_PATH,
            'Plugin' => APP_PATH
        ));
        $instance->registerDirs(array(
            FRAME_PATH,
            FRAME_PATH . 'Core',
            FRAME_PATH . 'Tests',
            FRAME_PATH . 'Server',
        ));
        //框架内置函数库
        $instance->loadFunc('Func', 'Common,Special');
    });
    //默认文件
    Config::loadFile(FRAME_PATH . 'Global-default.conf.php');
    //定义应用标识码
    //对多个相同应用情况下的缓存服务提供前缀防止缓存段共用问题;
    define('APP_UUID', strtolower(substr(md5(APP_PATH), 0, 6)));
    //composer第三方库加载支持
    is_file(FRAME_PATH . 'Vendor/autoload.php') and require FRAME_PATH . 'Vendor/autoload.php';
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
        $log = Norma\Server\Log::factory('monolog');
        Norma\Server\ErrorHandler::register('monolog', array($log), function () use ($log) {
            $log->pushHandler(new Monolog\Handler\ChromePHPHandler(Norma\Server\Log::INFO));
            $log->pushHandler(new AEStreamHandler('Log/' . date('Y-m-d') . "/ERROR.log", Norma\Server\Log::ERROR));
            $log->pushHandler(new AEStreamHandler('Log/' . date('Y-m-d') . "/WARN.log", Norma\Server\Log::WARNING));
        });
    }
        
    //插件支持
    \Core\Plugin\Manager::loadPlugin(FRAME_PATH . 'Plugin');

    \Core\Plugin\Manager::loadPlugin(APP_PATH . 'Plugin', '');
});
////核心初始化结束
