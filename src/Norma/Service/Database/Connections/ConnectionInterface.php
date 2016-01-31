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

namespace Norma\Service\Database\Connections;

use Closure;
/**
 * 数据库连接接口声明
 * 
 * 用于实现对连接有基本哪些操作
 */
interface ConnectionInterface{
    /**
     * 在一个数据表上进行查询
     *
     * @param  string  $table 需要进行查询的数据表
     * @return \Norma\Service\Database\Query\Builder
     */
    public function table($table);

    /**
     * 取得新的原始查询表达式对象.
     *
     * @param  mixed  $value
     * @return \Norma\Service\Database\Query\Expression
     */
    public function raw($value);

    /**
     * 运行查询语句并返回单个结果.
     *
     * @param  string  $query 查询语句
     * @param  array   $bindings 预处理参数
     * @return mixed
     */
    public function selectOne($query, $bindings = []);

    /**
     * 在一个数据库上运行查询语句.
     *
     * @param  string  $query 查询语句
     * @param  array   $bindings 预处理参数
     * @return array
     */
    public function select($query, $bindings = []);

    /**
     * 在一个数据库上运行插入语句.
     *
     * @param  string  $query 查询语句
     * @param  array   $bindings 预处理参数
     * @return bool
     */
    public function insert($query, $bindings = []);

    /**
     * 在一个数据库上运行更新语句.
     *
     * @param  string  $query 查询语句
     * @param  array   $bindings 预处理参数
     * @return int
     */
    public function update($query, $bindings = []);

    /**
     * 在一个数据库上运行删除语句..
     *
     * @param  string  $query 查询语句
     * @param  array   $bindings 预处理参数
     * @return int
     */
    public function delete($query, $bindings = []);

    /**
     * 执行一个SQL语句并返回布尔值.
     *
     * @param  string  $query 查询语句
     * @param  array   $bindings 预处理参数
     * @return bool
     */
    public function statement($query, $bindings = []);

    /**
     * 执行一个SQL语句并返回受影响行数.
     *
     * @param  string  $query 查询语句
     * @param  array   $bindings 预处理参数
     * @return int
     */
    public function affectingStatement($query, $bindings = []);

    /**
     * 在PDO上运行文件未进行参数处理的原始查询.
     *
     * @param  string  $query 查询语句
     * @return bool
     */
    public function unprepared($query);

    /**
     * 预处理绑定参数.
     *
     * @param  array  $bindings 预处理绑定参数
     * @return array
     */
    public function prepareBindings(array $bindings);

    /**
     * 在一次事务中执行Closure.
     *
     * @param  \Closure  $callback
     * @return mixed
     *
     * @throws \Throwable
     */
    public function transaction(Closure $callback);

    /**
     * 开始一次新的事务.
     *
     * @return void
     */
    public function beginTransaction();

    /**
     * 提交已激活事务.
     *
     * @return void
     */
    public function commit();

    /**
     * 在活动事务上回滚操作.
     *
     * @return void
     */
    public function rollBack();

    /**
     * 获取活动事务数.
     *
     * @return int
     */
    public function transactionLevel();

    /**
     * 在dry-run模式下执行Closure.
     *
     * @param  \Closure  $callback
     * @return array
     */
    public function pretend(Closure $callback);
}
