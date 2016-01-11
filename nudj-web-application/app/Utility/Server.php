<?php

namespace App\Utility;

class Server {

    public static function getServerStatus($url, $port, $returnError = false, $timeout = 2)
    {
        $fp = @fsockopen($url, $port, $errno, $errstr, $timeout);

        if(!$returnError)
            return (bool) $fp;
        else
            return compact(['errno', 'errstr']);
    }

}