<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_Nudges {

	// App\NSX300\NSX300_Nudges::ping()
	public static function ping(){
		return "pong";
	}

	// \App\NSX300\NSX300_Nudges::total_number_of_nudges_for_job_id($id)
	public static function total_number_of_nudges_for_job_id($id){
		$dbresults = DB::select('select count(*) as xcount from nudges where job_id=?',[$id]);
		foreach($dbresults as $dbresult){
			return (int)$dbresult->xcount;		
		}
	}

	// \App\NSX300\NSX300_Nudges::number_of_distinct_referrals_contacting_candidates_for_job_id($id)
	public static function number_of_distinct_referrals_contacting_candidates_for_job_id($id){
		$dbresults = DB::select('select distinct referrer_id from nudges where job_id=?',[$id]);
		return count($dbresults);
	}

	// \App\NSX300\NSX300_Nudges::number_of_referrals_from_hirer_for_job_id($id)
	public static function number_of_referrals_requests_from_hirer_for_job_id($id){
		$hirer_id = App\NSX300\NSX300_Jobs::hirer_id_for_job_id_or_null($id);
		// Not doable for the moment
	}

}
