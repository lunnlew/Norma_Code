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
namespace Norma\Service\Segment;

class Factory extends \Norma\Service\Factory
{

    /**
     * 获取正式服务名
     * @param  string $name 服务名
     * @static
     * @return string 正式服务名
     */
    public static function getRealServiceName($name, $prex = 'Norma')
    {
        if (in_array($name, array(
            'LAESegment',
            'SAESegment',
            'BaeSegment',
        ))) {
            return self::getApiName('Segment', $name, $prex);
        } else {
            return false;
        }
    }
}
