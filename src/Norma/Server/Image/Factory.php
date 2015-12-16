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

namespace Norma\Server\Image;

/**
 * Image Factory
 */
class Factory extends \Norma\Server\Factory
{
    public static function getServerName($name, $prex = '')
    {
        $server_name = 'LAEImage';
        switch ($name) {
            case 'saeimage':
                $server_name = 'SAEImage';
                break;
            case 'gdimage':
                $server_name = 'LAEGDImage';
                break;
            case 'image':
            case 'laeimage':
                $server_name = 'LAEImage';
                break;
        }

        return self::getApiName('Image', $server_name);
    }
}
