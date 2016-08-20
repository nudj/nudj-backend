<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_ApplicationsX1 {

    public static function insertRecord($name,$email,$link,$referrer){
        $uuid = uniqid();
        $datetime = date('Y-m-d H:i:s');
        DB::insert('insert into applicationsx1 (uuid,name,email,link,referrer,datetime) values (?,?,?,?,?,?)',[$uuid,$name,$email,$link,$referrer,$datetime]);
    }

}
