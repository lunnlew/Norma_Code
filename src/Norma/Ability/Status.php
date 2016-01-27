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
namespace Norma\Ability;

class Status{
	// 区间时间信息
    protected static $info = [];
    // 区间内存信息
    protected static $mem = [];

    /**
     * 记录时间（微秒）和内存使用情况
     * @param string $name 标记位置
     * @param mixed $value 标记值 留空则取当前 time 表示仅记录时间 否则同时记录时间和内存
     * @return mixed
     */
    public static function remark($name, $value = '')
    {
        // 记录时间和内存使用
        static::$info[$name] = is_float($value) ? $value : microtime(true);
        if ('time' != $value) {
            static::$mem['mem'][$name]  = is_float($value) ? $value : memory_get_usage();
            static::$mem['peak'][$name] = memory_get_peak_usage();
        }
    }

    /**
     * 统计某个区间的时间（微秒）使用情况
     * @param string $start 开始标签
     * @param string $end 结束标签
     * @param integer|string $dec 小数位
     * @return integer
     */
    public static function getRangeTime($start, $end, $dec = 6)
    {
        if (!isset(static::$info[$end])) {
            static::$info[$end] = microtime(true);
        }
        return number_format((static::$info[$end] - static::$info[$start]), $dec);
    }

    /**
     * 统计从开始到统计时的时间（微秒）使用情况
     * @param integer|string $dec 小数位
     * @return integer
     */
    public static function getUseTime($dec = 6)
    {
        return number_format((microtime(true) - START_TIME), $dec);
    }

    /**
     * 获取当前访问的吞吐率情况
     * @return string
     */
    public static function getThroughputRate()
    {
        return number_format(1 / static::getUseTime(), 2) . 'req/s';
    }

    /**
     * 记录区间的内存使用情况
     * @param string $start 开始标签
     * @param string $end 结束标签
     * @param integer|string $dec 小数位
     * @return string
     */
    public static function getRangeMem($start, $end, $dec = 2)
    {
        if (!isset(static::$mem['mem'][$end])) {
            static::$mem['mem'][$end] = memory_get_usage();
        }
        $size = static::$mem['mem'][$end] - static::$mem['mem'][$start];
        $a    = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pos  = 0;
        while ($size >= 1024) {
            $size /= 1024;
            $pos++;
        }
        return round($size, $dec) . " " . $a[$pos];
    }

    /**
     * 统计从开始到统计时的内存使用情况
     * @param integer|string $dec 小数位
     * @return string
     */
    public static function getUseMem($dec = 2)
    {
        $size = memory_get_usage() - START_MEM;
        $a    = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pos  = 0;
        while ($size >= 1024) {
            $size /= 1024;
            $pos++;
        }
        return round($size, $dec) . " " . $a[$pos];
    }

    /**
     * 统计区间的内存峰值情况
     * @param string $start 开始标签
     * @param string $end 结束标签
     * @param integer|string $dec 小数位
     * @return mixed
     */
    public static function getMemPeak($start, $end, $dec = 2)
    {
        if (!isset(static::$mem['peak'][$end])) {
            static::$mem['peak'][$end] = memory_get_peak_usage();
        }
        $size = static::$mem['peak'][$end] - static::$mem['peak'][$start];
        $a    = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pos  = 0;
        while ($size >= 1024) {
            $size /= 1024;
            $pos++;
        }
        return round($size, $dec) . " " . $a[$pos];
    }

    /**
     * 获取文件加载信息
     * @param bool $detail 是否显示详细
     * @return void
     */
    public static function getFile($detail = false)
    {
        if ($detail) {
            $files = get_included_files();
            $info  = [];
            foreach ($files as $key => $file) {
                $info[] = $file . ' ( ' . number_format(filesize($file) / 1024, 2) . ' KB )';
            }
            return $info;
        }
        return count(get_included_files());
    }
}
