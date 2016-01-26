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

use Norma\Service\Cache\Base;

/**
 * 本地硬盘文件缓存实现
 *
 * @package  Norma\Service\Cache
 * @subpackage  Drive
 * @author    LunnLew <lunnlew@gmail.com>
 */
class LAEFile extends Base
{
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
    public function checkDriver()
    {
        if (is_writable(RUNTIME_PATH)) {
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
    }
    /**
     * 设置缓存值
     * @param string  $key    缓存key
     * @param string  $var    缓存值
     * @param integer $expire 过期时间
     */
    public function set($key, $var, $compress = '', $expire = 3600)
    {
        $file_path = $this->getFilePath($key);
        $data = $this->encode($var, $expire);
        $toWrite = true;
        /*
			         * Skip if Existing Caching in Options
		*/
        if (isset($this->options['skipExisting']) && $this->options['skipExisting'] == true && file_exists($file_path)) {
            $content = $this->readfile($file_path);
            $old = $this->decode($content);
            $toWrite = false;
            if ($this->isExpired($old)) {
                $toWrite = true;
            }
        }

        if ($toWrite == true) {
            $f = fopen($file_path, "w+");
            fwrite($f, $data);
            fclose($f);
        }
    }
    /**
     * 获取缓存值
     * @param  string $key 缓存key
     * @return fixed  缓存值
     */
    public function get($key)
    {
        $file_path = $this->getFilePath($key);
        if (!file_exists($file_path)) {
            return null;
        }
        $content = $this->readfile($file_path);
        $object = $this->decode($content);
        if ($this->isExpired($object)) {
            @unlink($file_path);
            $this->autoCleanExpired();

            return null;
        }

        return $object['value'];
    }
    /**
     * 增值操作
     * @param  string  $key   缓存key
     * @param  integer $value 整数值 默认为1
     * @return bool    value/false
     */
    public function incr($key, $value = 1)
    {
        return false;
    }
    /**
     * 减值操作
     * @param  string  $key   缓存key
     * @param  integer $value 整数值 默认为1
     * @return bool    value/false
     */
    public function decr($key, $value = 1)
    {
        return false;
    }
    /**
     * 删除缓存项
     * @param  string $key 缓存key
     * @return bool   true/false
     */
    public function delete($key)
    {
        $file_path = $this->getFilePath($key, true);
        if (@unlink($file_path)) {
            return true;
        } else {
            return false;
        }
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
        $path = $this->getPath();
        $dir = @opendir($path);
        if (!$dir) {
            throw new Exception("Can't read PATH:" . $path, 94);
        }

        while ($file = readdir($dir)) {
            if ($file != "." && $file != ".." && is_dir($path . "/" . $file)) {
                // read sub dir
                $subdir = @opendir($path . "/" . $file);
                if (!$subdir) {
                    throw new Exception("Can't read path:" . $path . "/" . $file, 93);
                }

                while ($f = readdir($subdir)) {
                    if ($f != "." && $f != "..") {
                        $file_path = $path . "/" . $file . "/" . $f;
                        unlink($file_path);
                    }
                } // end read subdir
            } // end if
        } // end while
    }
    /**
     * 缓存清空
     * @return
     */
    public function flushAll()
    {
        return $this->flush();
    }
    //isExsits
    public function isExsits($key)
    {
        $file_path = $this->getFilePath($key, true);
        if (!file_exists($file_path)) {
            return false;
        } else {
            // check expired or not
            $value = $this->get($key);
            if ($value == null) {
                return false;
            } else {
                return true;
            }
        }
    }
    /*
		     * Return total cache size + auto removed expired files
	*/
    public function stats()
    {
        $res = array(
            "info" => "",
            "size" => "",
            "data" => "",
        );
        $path = $this->getPath();
        $dir = @opendir($path);
        if (!$dir) {
            throw new Exception("Can't read PATH:" . $path, 94);
        }
        $total = 0;
        $removed = 0;
        while ($file = readdir($dir)) {
            if ($file != "." && $file != ".." && is_dir($path . "/" . $file)) {
                // read sub dir
                $subdir = @opendir($path . "/" . $file);
                if (!$subdir) {
                    throw new Exception("Can't read path:" . $path . "/" . $file, 93);
                }
                while ($f = readdir($subdir)) {
                    if ($f != "." && $f != "..") {
                        $file_path = $path . "/" . $file . "/" . $f;
                        $size = filesize($file_path);
                        $object = $this->decode($this->readfile($file_path));
                        if ($this->isExpired($object)) {
                            unlink($file_path);
                            $removed = $removed + $size;
                        }
                        $total = $total + $size;
                    }
                } // end read subdir
            } // end if
        } // end while

        $res['size'] = $total - $removed;
        $res['info'] = array(
            "Total" => $total,
            "Removed" => $removed,
            "Current" => $res['size'],
        );

        return $res;
    }
    //自动清理过期
    public function autoCleanExpired()
    {
        $autoclean = $this->get("key_clean_up_driver_files");
        if ($autoclean == null) {
            $this->set("key_clean_up_driver_files", 3600 * 24);
            $res = $this->stats();
        }
    }
    //是否过期
    public function isExpired($object)
    {
        if (isset($object['expired_time']) && @date("U") >= $object['expired_time']) {
            return true;
        } else {
            return false;
        }
    }
    /*
		     * Object for Files & SQLite encode
	*/
    public function encode($data, $expire = 3600)
    {
        return serialize(array(
            "expired_time" => @date("U") + $expire,
            "value" => $data,
        ));
    }
    /*
		     * Object for Files & SQLite decode
	*/
    public function decode($value)
    {
        $x = @unserialize($value);
        if ($x == false) {
            return $value;
        } else {
            return $x;
        }
    }
    /*
		     * Read File
		     * Use file_get_contents OR ALT read
	*/
    public function readfile($file)
    {
        if (function_exists("file_get_contents")) {
            return file_get_contents($file);
        } else {
            $string = "";

            $file_handle = @fopen($file, "r");
            if (!$file_handle) {
                throw new Exception("Can't Read File", 96);

            }
            while (!feof($file_handle)) {
                $line = fgets($file_handle);
                $string .= $line;
            }
            fclose($file_handle);

            return $string;
        }
    }
    //获得缓存路径
    public function getPath()
    {
        return RUNTIME_PATH . 'FileCache/' . $this->group() . '/';
    }
    /*
		     * Return $FILE FULL PATH
	*/
    private function getFilePath($key, $skip = false)
    {
        $path = $this->getPath();
        $code = md5($key);
        $folder = substr($code, 0, 2);
        $path = $path . "/" . $folder;
        /*
			         * Skip Create Sub Folders;
		*/
        if ($skip == false) {
            if (!file_exists($path)) {
                if (!@mkdir($path, 0777, true)) {
                    throw new Exception("PLEASE CHMOD " . $this->getPath() . " - 0777 OR ANY WRITABLE PERMISSION!", 92);
                }

            } elseif (!is_writeable($path)) {
                @chmod($path, 0777);
            }
        }

        $file_path = $path . "/" . $code . ".txt";

        return $file_path;
    }
}
