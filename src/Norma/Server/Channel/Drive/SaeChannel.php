<?php
namespace Norma\Server\Counter\Drive;

use Norma\Server\Counter\Base;

/**
 * SAE环境下的Channel驱动
 */
final class SaeChannel extends Base
{
    //云服务对象
    public $object = '';
    public function __construct()
    {
        $this->object = new \SaeChannel();
    }
    public function createChannel(channel,$duration = 3600)
    {
    }
    public function sendMessage($channel, $content)
    {
    }
}
