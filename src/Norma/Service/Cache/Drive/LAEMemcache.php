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

namespace Norma\Service\Cache\Drive;

use Memcache;
use Norma\Service\Cache\Base;

/**
 * 本地Memcache缓存实现
 *
 * @package  Norma\Service\Cache
 * @subpackage  Drive
 * @author    LunnLew <lunnlew@gmail.com>
 * @final
 */
final class LAEMemcache extends Base {
	/**
	 * 配置项
	 * @var array
	 * @access protected
	 */
	protected $options = array(
		'group' => '[APP_UUID]',
		'expire' => 3600,
		'compress' => 1,
		'servers' => array(
			'host' => '127.0.0.1',
			'port' => 11211,
		),
	);
	protected $mmc;
	/**
	 * 检查驱动状态
	 * @return bool
	 */
	public function checkDriver() {
		if (!function_exists("memcache_connect")) {
			throw new \Norma\Exception\RuntimeException("请检查是否启用了memcache服务");
		}
	}
	/**
	 *  初始化服务
	 * @return bool
	 */
	public function initService() {
		try {
			$this->mmc = new Memcache;
		} catch (\Exception $e) {
			throw new \Norma\Exception\UnknownServiceException('初始化Memcahce失败!');
		};
		//支持多个memcache服务器
		if (isset($this->options['servers']['host'])) {
			$this->mmc->addService($this->options['servers']['host'], $this->options['servers']['port']);
		} else {
			foreach ($this->options['servers'] as $v) {
				$this->mmc->addService($v['host'], $v['port']);
			}
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
	public function set($key, $var, $compress = '', $expire = 3600) {
		if (!$this->mmc) {
			return;
		}
		if (!$expire) {
			$expire = $this->options['expire'];
		}
		if ($compress != '') {
			$this->options['compress'] = $compress;
		}

		return $this->mmc->set($this->makeKey($key), $var, $this->options['compress'] ? MEMCACHE_COMPRESSED : 0, $expire);
	}
	/**
	 * 获取缓存值
	 * @param  string $key 缓存key
	 * @return fixed  缓存值
	 */
	public function get($key) {
		if (!$this->mmc) {
			return;
		}

		return $this->mmc->get($this->makeKey($key));
	}
	/**
	 * 增值操作
	 * @param  string  $key   缓存key
	 * @param  integer $value 整数值 默认为1
	 * @return bool    value/false
	 */
	public function incr($key, $value = 1) {
		if (!$this->mmc) {
			return;
		}

		return $this->mmc->increment($this->makeKey($key), $value);
	}
	/**
	 * 减值操作
	 * @param  string  $key   缓存key
	 * @param  integer $value 整数值 默认为1
	 * @return bool    value/false
	 */
	public function decr($key, $value = 1) {
		if (!$this->mmc) {
			return;
		}

		return $this->mmc->decrement($this->makeKey($key), $value);
	}
	/**
	 * 删除缓存项
	 * @param  string $key 缓存key
	 * @return bool   true/false
	 */
	public function delete($key) {
		if (!$this->mmc) {
			return;
		}

		return $this->mmc->delete($this->makeKey($key));
	}
	/**
	 * 压缩缓存项
	 *
	 * 默认大于2k以0.2压缩比压缩.
	 * @param integer $threshold   数据大小
	 * @param float   $min_savings 压缩比
	 */
	public function compress($threshold = 2000, $min_savings = 0.2) {
		if (!$this->mmc) {
			return;
		}

		$this->mmc->setCompressThreshold($threshold, $min_savings);
	}
	/**
	 * 缓存过期
	 * @return
	 */
	public function flush() {
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
	public function flushAll() {
		if (!$this->mmc) {
			return;
		}

		return $this->mmc->flush();
	}
}
