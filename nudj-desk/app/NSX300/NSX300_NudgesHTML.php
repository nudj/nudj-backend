<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_NudgesHTML {

    // \App\NSX300\NSX300_NudgesHTML::nudge_request_as_html_li($nudge_request)
    public static function nudge_request_as_html_li($nudge_request){
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
        $referrer_id = $nudge_request['referrer_id'];
        $referrer_name = \App\NSX300\NSX300_Referrals::referral_id_to_name($referrer_id);
        $candidate_id = $nudge_request['candidate_id'];
        $candidate_record = \App\NSX300\NSX300_Contacts::get_contact_record_by_identifier_or_null($candidate_id);
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
        $candidate_name = $candidate_record['alias'];
        $operation_date = $nudge_request['created_at'];
        $html = '';
        $html .= '<li>';
            $html .= "referrer: id:".$referrer_id."; referrer name: <b>".$referrer_name."</b>; <br />";
            $html .= "candidate: id:".$candidate_id."; candidate name: <b>".$candidate_name."</b>; <br />";
            $html .= "operation date: <b>".$operation_date."</b>";
        $html .= '</li>';        
        return $html;
    }

    // \App\NSX300\NSX300_NudgesHTML::array_of_nudge_requests_as_html_lis($nudge_requests)
    public static function array_of_nudge_requests_as_html_lis($nudge_requests){
        $array = array_map(function($nudge_request){
            return \App\NSX300\NSX300_NudgesHTML::nudge_request_as_html_li($nudge_request); 
        },$nudge_requests);
        return implode('',$array);
    }


}
