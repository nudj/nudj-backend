<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_ApplicationsHTML {

    public static function application_request_as_html_li($application_request){
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
        $referrer_id = $application_request['referrer_id'];
        $referrer_record = \App\NSX300\NSX300_Users::get_user_record_by_identifier_or_null($referrer_id);
        $referrer_name = $referrer_record['name'];
        $candidate_id = $application_request['candidate_id'];
        $candidate_record = \App\NSX300\NSX300_Users::get_user_record_by_identifier_or_null($candidate_id);
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
        $candidate_name = $candidate_record['name'];
        $operation_date = $application_request['created_at'];
        $html = '';
        $html .= '<li>';
            $html .= "referrer: id:".$referrer_id."; referrer name: <b>".$referrer_name."</b>; <br />";
            $html .= "candidate: id:".$candidate_id."; candidate name: <b>".$candidate_name."</b>; <br />";
            $html .= "operation date: <b>".$operation_date."</b>";
        $html .= '</li>';        
        return $html;        
    }

    // \App\NSX300\NSX300_ApplicationsHTML::array_of_application_requests_as_html_lis($application_requests)
    public static function array_of_application_requests_as_html_lis($application_requests){
        $array = array_map(function($application_request){
            return \App\NSX300\NSX300_ApplicationsHTML::application_request_as_html_li($application_request); 
        },$application_requests);
        return implode('',$array);
    }

}
