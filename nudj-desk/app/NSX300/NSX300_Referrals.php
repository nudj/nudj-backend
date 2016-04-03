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

    // \App\NSX300\NSX300_Referrals::referral_requests_for_job_identifier($identifier)
    public static function referral_requests_for_job_identifier($identifier){
        $dbresults = DB::select('select * from referrals where job_id=?',[$identifier]);
        return array_map(function($dbresult){
            return (array)$dbresult;
        },$dbresults);
    }

    // \App\NSX300\NSX300_Referrals::referral_id_to_name($identifier)
    public static function referral_id_to_name($identifier){
        // The key here is that the referral identifier is a contact identifier
        $record = \App\NSX300\NSX300_Contacts::get_contact_record_by_identifier_or_null($identifier);
        return $record['alias'];
    }

}
