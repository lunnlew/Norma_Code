<?php
namespace Norma\Server\KVDB;

class Factory extends \Norma\Server\Factory
{
    public static function getServerName($name, $prex = '')
    {
        $server_name = 'LAEKVDB';
        switch ($name) {
            case 'kvdb':
                if (RUN_ENGINE == 'SAE') {
                    if (function_exists('SAEKVDB')) {
                        $server_name = 'SAEKVDB';
                    }
                } elseif (RUN_ENGINE == 'BAE') {
                    if (class_exists('BaeKVDB')) {
                        $server_name = 'BaeKVDB';
                    }
                } else {
                    if (class_exists('KVDB')) {
                        $server_name = 'LAEKVDB';
                    }
                }

                break;
        }

        return self::getApiName('KVDB', $server_name);
    }
}
