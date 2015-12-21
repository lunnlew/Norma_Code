<?php
namespace Norma\Service\StreamHandler\Drive;

use Monolog\Handler\StreamHandler;

/**
 * ACE的Storage驱动
 * 所有文件名使用相对于数据存储区域的路径
 *
 */
final class LAEStreamHandler extends StreamHandler
{
    /**
     * @param string  $stream
     * @param integer $level  The minimum logging level at which this handler will be triggered
     * @param Boolean $bubble Whether the messages that are handled can bubble up the stack or not
     */
    public function __construct(array $params)
    {
        parent::__construct($params[0], $params[1], $params[2]);
    }
    protected function write(array $record)
    {
        if (null === $this->stream) {
            if (!$this->url) {
                throw new \LogicException('Missing stream url, the stream can not be opened. This may be caused by a premature call to close().');
            }
            $this->errorMessage = null;
            set_error_handler(array($this, 'customErrorHandler'));
            //使用Storage只是测试,日志不合适使用Storage
            \Norma\Service\Storage::factory()->setArea(LOG_PATH);
            if (!\Norma\Service\Storage::factory()->write($this->url, (string) $record['formatted'], FILE_APPEND)) {
                return 0;
            }

            restore_error_handler();
        }
    }
    public function customErrorHandler($code, $msg)
    {
        $this->errorMessage = preg_replace('{^fopen\(.*?\): }', '', $msg);
    }
}
