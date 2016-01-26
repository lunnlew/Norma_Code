<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Service\ServerStatus\Drive;

use Norma\Service\ServerStatus\Base;

/**
 * 非云计算环境下的Storage驱动
 * 所有文件名使用相对于数据存储区域的路径
 */
final class Linux extends Base
{
    public function __construct()
    {
    }
    //获取cpu的空闲百分比
    public function getCpufree()
    {
        $cmd = "top -n 1 -b -d 0.1 | grep 'Cpu'"; //调用top命令和grep命令
        //%Cpu(s):  8.5 us, 11.5 sy, 17.0 ni, 62.9 id,  0.0 wa,  0.0 hi,  0.0 si,  0.0 st
        $lastline = exec($cmd, $output);
        preg_match_all('/(\d+\.\d+)/is', $lastline, $matches);
        return $matches[0][3];
    }
//获取内存空闲百分比
    public function geMemfree()
    {
        $cmd = 'free -m'; //调用free命令
        $lastline = exec($cmd, $output);

        preg_match('/Mem:\s+(\d+)/', $output[1], $matches);
        $memtotal = $matches[1];
        preg_match('/(\d+)$/', $output[2], $matches);
        $memfree = $matches[1] * 100.0 / $memtotal;

        return $memfree;
    }

//获取某个程序当前的进程数
    public function getProcCount($name)
    {
        $cmd = "ps -e"; //调用ps命令
        $output = shell_exec($cmd);

        $result = substr_count($output, ' ' . $name);
        return $result;
    }
}
