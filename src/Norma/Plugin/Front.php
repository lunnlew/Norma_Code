<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Plugin;

class Front
{
    /**
     * 供插件管理器主动加载的入口
     */
    public function __construct()
    {
        //你想自动挂接的钩子列表
        \Norma\PluginManager::set('setRequestType', array(&$this, 'setRequestType'));
    }
    public function setRequestType()
    {
        switch (false) {
            case is_ajax():
                $GLOBALS['request_type'] = 'ajax';
                break;
            default:
                $GLOBALS['request_type'] = 'common';
                break;
        }
    }
    public function output()
    {
        echo \FrontData::toJson();
        exit;
    }
}
