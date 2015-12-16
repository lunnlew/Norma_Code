<?php
namespace Norma\Server\Segment\Drive;

use Norma\Server\Segment\Base;

/**
 *
 *分词服务
 *
 */
class SAESegment extends Base
{
    public $object = '';
    public function __construct()
    {
        $this->object = new \SaeSegment();
    }
}
