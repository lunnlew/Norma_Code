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

namespace Norma\Service\Image\Drive;

use Norma\Service\Image\Base;

/**
 * Image服务驱动
 *
 * php最低支持版本5.4
 */
final class LAEImage extends Base
{
    public $object;
    public $files = array();
    public $width = '';
    public $height = '';
    public $mode = \Norma\Service\Image\Mode::WIDTH;
    public function __construct(mixed $files)
    {
        if (is_array($files)) {
            foreach ($files as $key => $file) {
                $this->files[$key]['name'] = $file;
                $this->files[$key]['ext'] = pathinfo($file)['extension'];
                $this->files[$key] = array_merge($this->files[$key], $this->getImgResource($file, $this->files[$key]['ext']));
            }
        } else {
            $this->files[] =
            array(
                'name' => $files,
                'ext' => pathinfo($files)['extension'],
            );
            $this->files[0] = array_merge($this->files[0], $this->getImgResource($file, $this->files[0]['ext']));
        }
    }
    public function setWidth()
    {
        $args = func_get_args();
        if (is_array($args[0])) {
            $args = $args[0];
        }
        $this->width = $args;

        return $this;
    }
    public function setHeight()
    {
        $args = func_get_args();
        if (is_array($args[0])) {
            $args = $args[0];
        }
        $this->height = $args;

        return $this;
    }
    public function thumb($mode = \Norma\Service\Image\Mode::WIDTH)
    {
        $params = array();
        //宽度上下限
        if (($mode & \Norma\Service\Image\Mode::MAXWIDTH)
            && ($mode & \Norma\Service\Image\Mode::MINWIDTH)
        ) {
            $this->width = array_pad($this->width, 2, 0);
            sort($this->width);
            list($params['minwidth'], $params['maxwidth']) = $this->width;
        } elseif ($mode & \Norma\Service\Image\Mode::MAXWIDTH) {
            //宽度上限
            $params['maxwidth'] = $this->width[0];
        } elseif ($mode & \Norma\Service\Image\Mode::MINWIDTH) {
            //宽度下限
            $params['minwidth'] = $this->width[0];
        }
        //高度上下限
        if (($mode & \Norma\Service\Image\Mode::MAXHEIGHT)
            && ($mode & \Norma\Service\Image\Mode::MINHEIGHT)
        ) {
            $this->height = array_pad($this->height, 2, 0);
            sort($this->height);
            list($params['minheight'], $params['maxheight']) = $this->height;
        } elseif ($mode & \Norma\Service\Image\Mode::MAXHEIGHT) {
            //高度上限
            $params['maxheight'] = $this->height[0];
        } elseif ($mode & \Norma\Service\Image\Mode::MINHEIGHT) {
            //高度下限
            $params['minheight'] = $this->height[0];
        }
        //指定宽度
        if ($mode & \Norma\Service\Image\Mode::WIDTH) {
            $params['width'] = $this->width[0];
        }
        //指定高度
        if ($mode & \Norma\Service\Image\Mode::HEIGHT) {
            $params['height'] = $this->height[0];
        }
        $this->_thumb($params);

        return $this;
    }
    private function _thumb($params = array())
    {
        foreach ($this->files as $key => $file) {
            //TODO
            return;
        }
    }
    private function getImgResource($filename, $ext)
    {
        $attr = array();
        switch ($ext) {
            case 'jpg':
                $arr['resource'] = imagecreatefromjpeg($filename);
                $arr['size'] = getimagesize($filename);
                break;

            default:
                # code...
                break;
        }

        return $arr;
    }
}
