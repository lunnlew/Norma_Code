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

namespace Norma\Service\Cache\Driver;

/**
 * 本地内存文件缓存实现
 * 支持Unix/Linux
 *
 * @package  Norma\Service\Cache
 * @subpackage  Drive
 * @author    LunnLew <lunnlew@gmail.com>
 * @final
 */
final class LAEMemfile extends LAEFile {
	/**
	 * 配置项
	 * @var array
	 * @access protected
	 */
	protected $options = array(
		'group' => '[APP_UUID]',
		'expire' => 3600,
		'compress' => 1,
		'skipExisting' => false,
	);
	/**
	 * 检查驱动状态
	 * @return bool
	 */
	public function checkDriver() {
		if (!is_writable(RUNTIME_PATH)) {
			throw new \Norma\Exception\RuntimeException("驱动服务目录不可写,请检查" . RUNTIME_PATH);
		}
	}
	/**
	 *  初始化服务
	 * @return bool
	 */
	public function initService() {
		if (!file_exists(RUNTIME_PATH . '/MemFileCache/')) {
			echo '<pre>';
			echo '为使用<strong>内存文件缓存</strong>方式,请使用以下命令建立目录:' . "\r\n";
			echo 'mkdir /dev/shm/MemFileCache' . "\r\n";
			echo 'ln -s /dev/shm/MemFileCache ' . RUNTIME_PATH . '/MemFileCache' . "\r\n";
			echo 'chmod -R 777 ' . RUNTIME_PATH . '/MemFileCache' . "\r\n";
			exit;
		}
	}
	//获得缓存路径
	public function getPath() {
		return RUNTIME_PATH . '/MemFileCache/' . $this->group() . '/';
	}
}
