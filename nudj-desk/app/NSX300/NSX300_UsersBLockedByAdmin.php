<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_UsersBLockedByAdmin {

    /*
        CREATE TABLE `users_blocked_by_admin` (
          `uuid` varchar(64) NOT NULL DEFAULT '',
          `blocked_user_id` int(11) NOT NULL,
          `operation_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
          PRIMARY KEY (`uuid`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    */

    public static function true_if_user_identified_by_id_is_currently_blocked_by_admin($useridentifier){
        $dbresults = DB::select('select * from users_blocked_by_admin where blocked_user_id=?',[$useridentifier]);
        foreach($dbresults as $dbresult){
            return true;        
        }
        return false;
    }

    public static function block_user($useridentifier){
        DB::insert('insert into users_blocked_by_admin (uuid,blocked_user_id) values (?,?)',[md5(microtime()),$useridentifier]);
    }

    public static function unblock_user($useridentifier){
        DB::insert('delete from users_blocked_by_admin where blocked_user_id=?',[$useridentifier]);
    }

}
