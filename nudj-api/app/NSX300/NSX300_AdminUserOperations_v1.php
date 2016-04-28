<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_AdminUserOperations_v1 {

    public static function true_if_user_identified_by_id_is_currently_a_special_access_1_user($useridentifier){
        $dbresults = DB::select('select * from special_access_1 where user_id=?',[$useridentifier]);
        foreach($dbresults as $dbresult){
            return true;        
        }
        return false;
    }

}
