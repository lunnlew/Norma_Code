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
 * 本地APC缓存实现
 *
 * @package  Norma\Server\Cache
 * @subpackage  Drive
 * @author    LunnLew <lunnlew@gmail.com>
 * @final
 */
namespace Norma\Server\Cache\Drive;

use Norma\Server\Cache\Base;

final class LAEapc extends Base
{
    /**
     * 检查驱动状态
     * @return bool
     */
    public function checkDriver()
    {
        if (function_exists("apc_fetch")) {
            return true;
        }

        return false;
    }
    /**
     *  初始化服务
     * @return bool
     */
    public function initServer()
    {
        $version = apc_fetch('version_' . $this->group());
        if (!empty($version)) {
            $this->version = $version;
        } else {
            apc_store('version_' . $this->group(), $this->version);
        }
    }
    /**
     * 设置缓存值
     * @param string  $key    缓存key
     * @param string  $var    缓存值
     * @param integer $expire 过期时间
     */
    public function set($key, $var, $expire = 3600)
    {
        if (!$expire) {
            $expire = $this->options['expire'];
        }

        return apc_store($this->makeKey($key), $var, $expire);
    }
    /**
     * 获取缓存值
     * @param  string $key 缓存key
     * @return fixed  缓存值
     */
    public function get($key)
    {
        return apc_fetch($this->makeKey($key));
    }
    /**
     * 增值操作
     * @param  string  $key   缓存key
     * @param  integer $value 整数值 默认为1
     * @todo
     * @return bool    value/false
     */
    public function incr($key, $value = 1)
    {
    }
    /**
     * 减值操作
     * @param  string  $key   缓存key
     * @param  integer $value 整数值 默认为1
     * @todo
     * @return bool    true/false
     */
    public function decr($key, $value = 1)
    {
    }
    /**
     * 删除缓存项
     * @param  string $key 缓存key
     * @return bool   value/false
     */
    public function delete($key)
    {
        return apc_delete($this->makeKey($key));
    }
    /**
     * 压缩缓存项
     *
     * 默认大于2k以0.2压缩比压缩.
     * @param integer $threshold   数据大小
     * @param float   $min_savings 压缩比
     */
    public function compress($threshold = 2000, $min_savings = 0.2)
    {
    }
    /**
     * 缓存过期
     * @return
     */
    public function flush()
    {
        if (false === $this->version) {
            $this->version = 1;
        } else {
            ++$this->version;
        }
        apc_store('version_' . $this->group(), $this->version);
    }
    /**
     * 缓存清空
     * @return
     */
    public function flushAll()
    {
        apc_clear_cache();

        return apc_clear_cache('user');
    }
}
