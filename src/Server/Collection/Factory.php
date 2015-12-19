<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Server\Collection;

/**
 * Collection工厂类
 *
 * @package  Norma
 * @subpackage  Server\Collection
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
        if (in_array(strtolower($name), array(
            'routecollection',
            'headerdatacollection',
            'aerverdatacollection',
            'responsecookiedatacollection',
            'frontdatacollection',
            'datacollection',
        ))) {
            return self::getApiName('Collection', $name, $prex);
        } else {
            return false;
        }
    }
}
