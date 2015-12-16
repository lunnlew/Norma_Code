<?php
/**
 * 用户应用自定义初始化加载
 *
 * 根据实际情况书写加载的模块等
 */
NormaTest::initialize(function () {
    ClassLoader::initialize(function ($instance) {
        //注册_autoload函数
        $instance->register();
        //More Coding
        $instance->registerDirs(array(
            APP_PATH
        ));
    });
});

class NormaTest extends NormaCore
{
    public static function execute($type = '')
    {
        //exit('Running OK!');
    }
}
