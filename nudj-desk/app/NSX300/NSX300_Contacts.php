<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_Contacts {

	// \App\NSX300\NSX300_Contacts::get_contact_record_by_identifier_or_null($identifier)
	public static function get_contact_record_by_identifier_or_null($identifier){
		$dbresults = DB::select('select * from contacts where id=?',[$identifier]);
		foreach($dbresults as $dbresult){
			return (array)$dbresult;		
		}
		return null;
        /*
            [
               "id"           => 5960,
               "user_id"      => 1,
               "contact_of"   => 39,
               "alias"        => "Robyn McGirl",
               "phone"        => "+447920549291",
               "country_code" => "GB",
               "suspicious"   => 0,
               "native"       => null,
               "favorite"     => null,
               "mute"         => null,
               "apple_id"     => null
            ]
        */
	}

}
