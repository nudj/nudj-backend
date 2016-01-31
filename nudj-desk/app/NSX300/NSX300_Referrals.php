<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_Referrals {

	// \App\NSX300\NSX300_Referrals::referral_requests_count_for_job_id($id)
	public static function referral_requests_count_for_job_id($id){
		$dbresults = DB::select('select count(*) as xcount from referrals where job_id=?',[$id]);
		foreach($dbresults as $dbresult){
			return (int)$dbresult->xcount;		
		}
		return null; // this never happens
	}

}
