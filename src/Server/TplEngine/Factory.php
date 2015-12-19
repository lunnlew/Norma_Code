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

namespace Norma\Server\TplEngine;

/**
 * 模板引擎工厂类
 *
 * @package  Norma
 * @subpackage  Server\TplEngine
 * @author    LunnLew <lunnlew@gmail.com>
 */
class Factory extends \Norma\Server\Factory
{
    /**
     * 获取正式服务名
     * @param  string $name 服务名
     * @static
     * @return string 正式服务名
     */
    public static function getRealServerName($name, $prex = 'Norma')
    {
        if (in_array($name, array(
            'Smarty',
            'Twig',
            'Tengine',
        ))) {
            return self::getApiName('TplEngine', $name, $prex);
        } else {
            return false;
        }
    }
}
