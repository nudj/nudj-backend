<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_AdminUserOperations_v1 {

    // -----------------------------------------------------------------------------------

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

    // -----------------------------------------------------------------------------------

    public static function true_if_user_identified_by_id_is_currently_a_special_access_1_user($useridentifier){
        $dbresults = DB::select('select * from special_access_1 where user_id=?',[$useridentifier]);
        foreach($dbresults as $dbresult){
            return true;        
        }
        return false;
    }

    public static function enable_special_access($useridentifier){
        DB::insert('insert into special_access_1 (user_id,added_datetime) values (?,?)',[$useridentifier,date("Y-m-d H:i:s")]);
    }

    public static function disable_special_access($useridentifier){
        DB::insert('delete from special_access_1 where user_id=?',[$useridentifier]);
    }

}
