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

namespace Norma\Server\ACM;

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
        if (in_array(strtolower($name), array(
            'authority',
        ))) {
            return self::getApiName('ACM', $name, $prex);
        } else {
            return false;
        }
    }
}
