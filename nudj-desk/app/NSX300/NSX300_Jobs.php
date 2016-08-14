<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_Jobs {

	// \App\NSX300\NSX300_Jobs::hirer_id_for_job_id_or_null($id)
	public static function hirer_id_for_job_id_or_null($id){
		$dbresults = DB::select('select user_id from jobs where id=?',[$id]);
		foreach($dbresults as $dbresult){
			return (int)$dbresult->user_id;		
		}
		return null;
	}

    // \App\NSX300\NSX300_Jobs::delete_job($id)
    public static function delete_job($id){
        DB::delete('delete from jobs where id=?',[$id]);
        return null;
    }

}
