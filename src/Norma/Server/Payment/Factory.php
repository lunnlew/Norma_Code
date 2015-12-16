<?php
namespace Norma\Server\Payment;
class Factory extends \Norma\Server\Factory
{
    public static function getServerName($name, $prex='')
    {
        $server_name = 'Alipay';
        switch ($name) {
            case 'alipay':
                $server_name = 'Alipay' ;
            break;
        }

        return 'Server_Payment_Adapter_'.$type;
    }
}
