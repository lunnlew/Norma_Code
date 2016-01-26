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
namespace Norma\OAPI\Liantu;

use Norma\OAPI\BaseV1 as RequestBase;

/**
 * 联图网 二维码 api
 *
 * http://www.liantu.com/pingtai/
 */
class Connect extends RequestBase
{
    /**
     * 构造函数
     */
    final public function __construct()
    {
        $this->cfg = include(__DIR__ . '/Api/liantu.php');
    }
}
