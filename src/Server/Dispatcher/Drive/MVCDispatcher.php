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

/**
 * 控制器分发类
 *
 * @package  Norma
 * @subpackage  Server
 * @author    LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Server\Dispatcher\Drive;

class MVCDispatcher
{
    protected $options = array();
    /**
     * 执行分发
     * @param Closure $class  获取控制器类
     * @param Closure $method 获取控制器方法
     */
    public function execute($class, $method)
    {
        //获得控制器Aop对象
        $controller = new $class;
        try {
            if (!preg_match('/^[_A-Za-z](\w)*$/', $method)) {
                // 非法操作
                throw new \ReflectionException();
            }
            $controller->{$method}();
        } catch (\ReflectionException $e) {
            exit('方法异常');
        }
    }
}
