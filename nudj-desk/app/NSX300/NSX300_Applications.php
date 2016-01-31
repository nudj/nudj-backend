<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_Applications {

	// \App\NSX300\NSX300_Applications::applications_requests_count_for_job_id($id)
	public static function applications_requests_count_for_job_id($id){
		$dbresults = DB::select('select count(*) as xcount from applications where job_id=?',[$id]);
		foreach($dbresults as $dbresult){
			return (int)$dbresult->xcount;		
		}
		return null; // this never happens
	}

}
