<?php
/**
 * Norma - A PHP Framework For Web
 *
 * @package  Norma
 * @author   LunnLew <lunnlew@gmail.com>
 */
namespace Norma\Service\ServiceStatus\Drive;

use Norma\Service\ServiceStatus\Base;

/**
 * 非云计算环境下的Storage驱动
 * 所有文件名使用相对于数据存储区域的路径
 */
final class Linux extends Base
{
    public function __construct()
    {

    }
}
