<?php
namespace Norma\Server\ErrorHandler;

class Factory extends \Norma\Server\Factory
{
    public static function getServerName($name, $prex = '')
    {
        $server_name = 'ErrorHandler';
        switch ($name) {
            case 'monolog':
                $server_name = 'MonologErrorHandler';
                break;
            default:
                $server_name = 'ErrorHandler';
                break;
        }

        return self::getApiName('ErrorHandler', $server_name);
    }
}
