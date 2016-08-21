<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_ApplicationsX1 {

    public static function insertRecord($jobid,$name,$email,$link,$referrer,$ipaddress){
        $uuid = uniqid();
        $datetime = date('Y-m-d H:i:s');
        DB::insert('insert into applicationsx1 (uuid,jobid,name,email,link,referrer,datetime,ipaddress) values (?,?,?,?,?,?,?,?)',[$uuid,$jobid,$name,$email,$link,$referrer,$datetime,$ipaddress]);
    }

}
