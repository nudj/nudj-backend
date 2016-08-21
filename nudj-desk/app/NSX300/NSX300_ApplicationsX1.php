<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_ApplicationsX1 {

    public static function get_records(){
        $answer = array();
        $dbresults = DB::select('select * from applicationsx1',[]);
        foreach($dbresults as $dbresult){
            $answer[] = (array)$dbresult;        
        }
        return $answer;
        /*
            [
                `uuid` varchar(128) NOT NULL DEFAULT '',
                `jobid` int(11) DEFAULT NULL,
                `name` text NOT NULL,
                `email` text NOT NULL,
                `link` text NOT NULL,
                `referrer` text NOT NULL,
                `datetime` datetime NOT NULL,
                `ipaddress` tinytext NOT NULL,
            ]
        */
    }

}
