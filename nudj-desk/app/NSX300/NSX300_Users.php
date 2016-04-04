<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_Users {

	// \App\NSX300\NSX300_Users::get_user_record_by_identifier_or_null($identifier)
	public static function get_user_record_by_identifier_or_null($identifier){
		$dbresults = DB::select('select * from users where id=?',[$identifier]);
		foreach($dbresults as $dbresult){
			return (array)$dbresult;		
		}
		return null;
        /*
            [
              `id` int(11) NOT NULL AUTO_INCREMENT,
              `phone` varchar(64) NOT NULL,
              `country_code` varchar(2) NOT NULL,
              `token` varchar(60) NOT NULL,
              `verification` varchar(6) NOT NULL,
              `verified` tinyint(1) DEFAULT NULL,
              `completed` tinyint(1) DEFAULT NULL,
              `email` varchar(255) DEFAULT NULL,
              `name` varchar(64) DEFAULT NULL,
              `image` varchar(255) DEFAULT NULL,
              `address` varchar(128) DEFAULT NULL,
              `position` varchar(128) DEFAULT NULL,
              `company` varchar(128) DEFAULT NULL,
              `status` smallint(6) DEFAULT NULL COMMENT 'inactive/hiring',
              `about` text,
              `findme` text,
              `settings` text,
              `created_at` datetime NOT NULL,
              `updated_at` datetime NOT NULL,
              `deleted_at` datetime DEFAULT NULL,
              `roles` text,
              `mobile` tinyint(1) DEFAULT '0',
              `facebook_token` varchar(512) DEFAULT NULL,
            ]
        */
	}

}
