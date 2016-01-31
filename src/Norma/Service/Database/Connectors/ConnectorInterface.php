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

namespace Norma\Service\Database\Connectors;

/**
 * 数据库连接器接口声明
 *
 * 用于实现如何连接一个数据源
 */
interface ConnectorInterface {
	/**
	 * 建立一个数据库连接.
	 *
	 * @param  array  $config 连接选项配置
	 * @return \ConnectionInterface 一个继承ConnectionInterface的连接对象
	 */
	public function connect(array $config);
}
