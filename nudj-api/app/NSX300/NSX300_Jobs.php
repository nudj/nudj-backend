<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_Jobs {

    public static function get_currency_bonus_for_job($jobid){
        $dbresults = DB::select('select * from jobs where id=?',[$jobid]);
        foreach($dbresults as $dbresult){
            return $dbresult->bonus_currency;        
        }
        return '';
    }

}
