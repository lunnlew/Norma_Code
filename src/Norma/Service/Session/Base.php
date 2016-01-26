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
namespace Norma\Service\Session;

class Base implements Face
{
    /**
     * session_open
     */
    public static function open($path, $name)
    {
        return true;
    }
    /**
     * session_close
     */
    public static function close()
    {
        return true;
    }
    /**
     * session_read
     * @param mixed $id session id
     */
    public static function read($id)
    {
    }
    /**
     * session_write
     * @param mixed $id   session id
     * @param mixed $data session data
     */
    public static function write($id, $data)
    {
    }
    /**
     * session_destroy
     * @param mixed $id session id
     */
    public static function destroy($id)
    {
    }
    /**
     * session_gc
     * @param int $maxLifeTime session最大生存时间
     */
    public static function gc($maxLifeTime = '3600')
    {
    }
}
