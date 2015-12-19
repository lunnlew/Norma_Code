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
 * SAE Memcache缓存实现
 *
 * @package  Norma\Server\Cache
 * @subpackage  Drive
 * @author    LunnLew <lunnlew@gmail.com>
 * @final
 */
namespace Norma\Server\Cache\Drive;

use Norma\Server\Cache\Base;

final class SAEMemcache extends Base
{
    protected $mmc;
    /**
     * 检查驱动状态
     * @return bool
     */
    public function checkDriver()
    {
        if (function_exists("memcache_init")) {
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
        $this->mmc = memcache_init();
        if (!$this->mmc) {
            throw new \Norma\Exception\NotSupportedException('初始化SAE Memcahce失败!');
        }
        $version = $this->mmc->get('version_' . $this->group()); //无数据第一次运行时的警告怎样抑制?
        if (!empty($version)) {
            $this->version = $version;
        } else {
            $this->mmc->set('version_' . $this->group(), $this->version);
        }
    }
    /**
     * 设置缓存值
     * @param string  $key    缓存key
     * @param string  $var    缓存值
     * @param integer $expire 过期时间
     */
    public function set($key, $var, $compress = '', $expire = 3600)
    {
        if (!$this->mmc) {
            return;
        }

        if (!$expire) {
            $expire = $this->options['expire'];
        }
        if ($compress != '') {
            $this->options['compress'] = $compress;
        }

        return $this->mmc->set($this->key($key), $var, $this->options['compress'] ? MEMCACHE_COMPRESSED : 0, $expire);
    }
    /**
     * 获取缓存值
     * @param  string $key 缓存key
     * @return fixed  缓存值
     */
    public function get($key)
    {
        if (!$this->mmc) {
            return;
        }

        return $this->mmc->get($this->key($key));
    }
    /**
     * 增值操作
     * @param  string  $key   缓存key
     * @param  integer $value 整数值 默认为1
     * @return bool    value/false
     */
    public function incr($key, $value = 1)
    {
        if (!$this->mmc) {
            return;
        }

        return $this->mmc->increment($this->key($key), $value);
    }
    /**
     * 减值操作
     * @param  string  $key   缓存key
     * @param  integer $value 整数值 默认为1
     * @return bool    value/false
     */
    public function decr($key, $value = 1)
    {
        if (!$this->mmc) {
            return;
        }

        return $this->mmc->decrement($this->key($key), $value);
    }
    /**
     * 删除缓存项
     * @param  string $key 缓存key
     * @return bool   true/false
     */
    public function delete($key)
    {
        if (!$this->mmc) {
            return;
        }

        return $this->mmc->delete($this->key($key));
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
        if (!$this->mmc) {
            return;
        }

        $this->mmc->setCompressThreshold($threshold, $min_savings);
    }
    /**
     * 缓存过期
     * @return
     */
    public function flush()
    {
        if (!$this->mmc) {
            return;
        }

        if (false === $this->version) {
            $this->version = 1;
        } else {
            ++$this->version;
        }
        $this->mmc->set('version_' . $this->group(), $this->version);
    }
    /**
     * 缓存清空
     * @return
     */
    public function flushAll()
    {
        if (!$this->mmc) {
            return;
        }

        return $this->mmc->flush();
    }
}
