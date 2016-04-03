<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_Nudges {

	// App\NSX300\NSX300_Nudges::ping()
	public static function ping(){
		return "pong";
	}

    // \App\NSX300\NSX300_Nudges::nudge_requests_for_job_identifier($identifier)
    public static function nudge_requests_for_job_identifier($identifier){
        $dbresults = DB::select('select * from nudges where job_id=?',[$identifier]);
        return array_map(function($dbresult){
            return (array)$dbresult;
        },$dbresults);
        /*
            [
               "id"           => 10,
               "employer_id"  => 1,
               "referrer_id"  => 1,
               "candidate_id" => 21,
               "job_id"       => 12,
               "hash"         => "txQioDwjNa",
               "created_at"   => "2016-02-17 09:44:53",
               "updated_at"   => "2016-02-17 09:44:53",
               "deleted_at"   => null
            ]
        */
    }

	// \App\NSX300\NSX300_Nudges::total_number_of_nudges_for_job_id($id)
	public static function total_number_of_nudges_for_job_id($id){
		$dbresults = DB::select('select count(*) as xcount from nudges where job_id=?',[$id]);
		foreach($dbresults as $dbresult){
			return (int)$dbresult->xcount;		
		}
	}

	// \App\NSX300\NSX300_Nudges::number_of_distinct_referrers_contacting_candidates_for_job_id($id)
	public static function number_of_distinct_referrers_contacting_candidates_for_job_id($id){
		$dbresults = DB::select('select distinct referrer_id from nudges where job_id=?',[$id]);
		return count($dbresults);
	}

	// \App\NSX300\NSX300_Nudges::number_of_referrals_from_hirer_for_job_id($id)
	public static function number_of_referrals_requests_from_hirer_for_job_id($id){
		$hirer_id = App\NSX300\NSX300_Jobs::hirer_id_for_job_id_or_null($id);
		// Not doable for the moment
	}

}
