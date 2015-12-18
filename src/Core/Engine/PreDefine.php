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
//

//框架类及云平台自有类统一化命名
if (C("enable_class_alias", false)) {
	class_alias('Norma\Server\Rank\Drive\\' . RUN_ENGINE . 'Rank', 'Rank');
	class_alias('Norma\Server\KVDB\Drive\\' . RUN_ENGINE . 'KVDB', 'KVDB');
	class_alias('Norma\Server\Counter\Drive\\' . RUN_ENGINE . 'Counter', 'Counter');
	class_alias('Norma\Server\Storage\Drive\\' . RUN_ENGINE . 'Storage', 'Storage');
}