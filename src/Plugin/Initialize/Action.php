<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Plugin\Initialize;

/**
 * Initialize
 */

class Action extends \Norma\Plugin\Base
{
    /**
     * 供插件管理器主动加载的入口
     * @param string $plugin 插件管理器
     */
    public function __construct()
    {
        \Norma\PluginManager::only('appInitialize', array(&$this, 'deafultAppInitialize'));
        \Norma\PluginManager::only('coreLazyInitialize', array(&$this, 'defaultCoreLazyInitialize'));
        \Norma\PluginManager::only('appLazyInitialize', array(&$this, 'defaultAppLazyInitialize'));
    }
    /**
     * @param  array  $options [description]
     * @return [type] [description]
     */
    public function deafultAppInitialize($options = array())
    {
        /**
         * 应用类库加载方案
         */
        \Norma\AutoloaderClassPsr0::initialize(function ($instance) {
            $instance->register();
            $instance->registerNamespaces(array(
                'Controller' => dirname(CONTRLLER_PATH),
                'Model' => dirname(MODEL_PATH),
                'Logic' => dirname(MODEL_PATH),
                'Library' => APP_PATH,
                'Custom' => APP_PATH,
                'Plugin' => APP_PATH,
                'Tag' => FRAME_PATH . 'Extension',
            ));
            $instance->registerDirs(array(
                APP_PATH . 'Custom',
            ));
            $instance->loadFunc('Custom', 'Func');
        });
        /**
         * 应用配置文件
         */
        \Norma\Config::loadFile(APP_PATH . 'Config/LAEGlobal.user.php');
        \Norma\Request::parse();
    }
    public function defaultCoreLazyInitialize()
    {
        //语言包路径
        defined('LANG_PATH') || define('LANG_PATH', APP_PATH . 'Language/');
        //模板路径
        defined('VIEW_PATH') || define('VIEW_PATH', APP_PATH . 'View/');
        //读数据路径
        defined('DATA_PATH') || define('DATA_PATH', FRAME_PATH . 'Data/');
        //编译路径
        defined('COMPILE_PATH') || define('COMPILE_PATH', RUNTIME_PATH . 'Compile/');
        //缓存路径
        defined('CACHE_PATH') || define('CACHE_PATH', RUNTIME_PATH . 'Cache/');
        //静态资源URL
        defined('ASSETS_URL') || define('ASSETS_URL', APP_URL . 'Assets/');
        //默认应用路径
        defined('APP_PATH') || define('APP_PATH', ENTRANCE_PATH . 'MyApp/');
        //默认应用name
        defined('APP_NAME') || define('APP_NAME', basename(APP_PATH));
        defined('APP_VERSION') || define('APP_VERSION', '1');
        //默认应用插件路径
        defined('APP_ADDONS_PATH') || define('APP_ADDONS_PATH', APP_PATH . 'Plugin/');
        //请求开始时间
        defined('START_TIME') || define('START_TIME', isset($_SERVER['REQUEST_TIME_FLOAT']) ? $_SERVER['REQUEST_TIME_FLOAT'] : '');
        //文件后缀
        defined('EXT') || define('EXT', '.php');
        //Third  Parts
        defined('THIRD_PATH') || define('THIRD_PATH', APP_PATH . 'Library/Third/');
        //设置应用插件默认加载方案
        \Norma\AutoloaderClassPsr0::initialize(function ($instance) {
            $instance->register();
            $instance->registerNamespace('Plugin', array(APP_ADDONS_PATH));
        });
    }

    public function defaultAppLazyInitialize()
    {
        /**
         * 视图加载方案
         */
        //视图风格名
        defined('THEME_NAME') || define('THEME_NAME', C('THEME_NAME', "page"));
        //静态资源URL
        defined('CSS_URL') || define('CSS_URL', str_replace('\\', '/', ASSETS_URL . "css" . DS));
        defined('JS_URL') || define('JS_URL', str_replace('\\', '/', ASSETS_URL . "js" . DS));
        defined('IMG_URL') || define('IMG_URL', str_replace('\\', '/', ASSETS_URL . "img" . DS));
    }
}
