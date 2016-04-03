<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_ReferralsHTML {

    // \App\NSX300\NSX300_ReferralsHTML::referral_request_as_html_li($referral_request)
    public static function referral_request_as_html_li($referral_request){
        /*
           [
               "id"          => 30,
               "job_id"      => 31,
               "referrer_id" => 5960,
               "created_at"  => "2016-04-03 08:56:06",
               "updated_at"  => "2016-04-03 08:56:06",
               "deleted_at"  => null,
               "hash"        => "BBvKjDWq2B"
           ]
        */
        $referrer_id = $referral_request['referrer_id'];
        $name = \App\NSX300\NSX300_Referrals::referral_id_to_name($referrer_id);
        $operation_date = $referral_request['created_at'];
        $html = '';
        $html .= '<li>';
            $html .= "referrer: id:".$referrer_id."; name: <b>".$name."</b>; operation date: <b>".$operation_date."</b>";
        $html .= '</li>';        
        return $html;
    }

    // \App\NSX300\NSX300_ReferralsHTML::array_of_referral_requests_as_html_lis($referral_requests)
    public static function array_of_referral_requests_as_html_lis($referral_requests){
        $array = array_map(function($referral_request){
            return \App\NSX300\NSX300_ReferralsHTML::referral_request_as_html_li($referral_request); 
        },$referral_requests);
        return implode('',$array);
    }

}
