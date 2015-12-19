<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Plugin\Filter;

/**
 * Filter
 */

class Action extends \Norma\Plugin\Base
{
    /**
     * 供插件管理器主动加载的入口
     */
    public function __construct()
    {
        parent::__construct(array());
        \Norma\PluginManager::only('inputFilter', array(&$this, 'inputFilter'), array('type' => 'all'));
    }
    /**
     * [inputFilter description]
     * see  http://www.w3school.com.cn/php/php_ref_filter.asp
     * @param  string $type    [description]
     * @param  [type] $filters [description]
     * @return [type] [description]
     */
    public function inputFilter($type = 'all', $filters = FILTER_UNSAFE_RAW)
    {
        exit('TODO');
    }
}
