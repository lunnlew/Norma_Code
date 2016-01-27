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
namespace Norma\OAPI\Demo;

use Norma\OAPI\BaseV2 as RequestBase;

/**
 */
class Test extends RequestBase
{
    public function _getCookie($name)
    {
        if (is_array($this->api_params[$this->api_name]['cookie'])) {
            $cookies = array();
            foreach ($this->api_params[$this->api_name]['cookie'] as $key => $value) {
                $cookies[] = $key.'='.$value;
            }

            return $cookies;
        } else {
            return explode(';', $this->api_params[$this->api_name]['cookie']);
        }
    }
}
