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
 * 本地xcache缓存实现
 *
 * @package  Norma\Service\Cache
 * @subpackage  Drive
 * @author    LunnLew <lunnlew@gmail.com>
 * @final
 */
namespace Norma\Service\Cache\Drive;

use Norma\Service\Cache\Base;

final class LAExcache extends Base
{
    /**
     * 检查驱动状态
     * @return bool
     */
    public function checkDriver()
    {
        if (function_exists("xcache_get")) {
            return true;
        }

        return false;
    }
    /**
     *  初始化服务
     * @return bool
     */
    public function initService()
    {
        $version = @unserialize(xcache_get('version_' . $this->group()));
        if (!empty($version)) {
            $this->version = $version;
        } else {
            xcache_set('version_' . $this->group(), serialize($this->version));
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

        return xcache_set($this->makeKey($key), serialize($var), $expire);
    }
    /**
     * 获取缓存值
     * @param  string $key 缓存key
     * @return fixed  缓存值
     */
    public function get($key)
    {
        return @unserialize(xcache_set($this->makeKey($key)));
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
     * @return bool    value/false
     */
    public function decr($key, $value = 1)
    {
    }
    /**
     * 删除缓存项
     * @param  string $key 缓存key
     * @return bool   true/false
     */
    public function delete($key)
    {
        return xcache_unset($this->makeKey($key));
    }
    /**
     * 压缩缓存项
     *
     * 默认大于2k以0.2压缩比压缩.
     * @param integer $threshold   数据大小
     * @param float   $min_savings 压缩比
     * @todo
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
        xcache_set('version_' . $this->group(), serialize($this->version));
    }
    /**
     * 缓存清空
     * @return
     */
    public function flushAll()
    {
        xcache_clear_cache(XC_TYPE_VAR, 0);

        return;
    }
}
