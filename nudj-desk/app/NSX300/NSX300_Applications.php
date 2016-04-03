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

    // \App\NSX300\NSX300_Applications::application_requests_for_job_identifier($identifier)
    public static function application_requests_for_job_identifier($identifier){
        $dbresults = DB::select('select * from applications where job_id=?',[$identifier]);
        return array_map(function($dbresult){
            return (array)$dbresult;
        },$dbresults);
        /*
            [
               "id"           => 10,
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

}
