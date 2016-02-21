<?php namespace App\Models;

use App\Models\BlockUser;
use App\Models\ReportUser;

class UnsafeUsers
{
	// UnsafeUsers::unsafe_userids_for_primary_user($primary_userid)
    public static function unsafe_userids_for_primary_user($primary_userid){
    	$array1 = ReportUser::get_reported_userids_for_primary_user($primary_userid);
    	$array2 = BlockUser::get_blocked_userids_for_primary_user($primary_userid);
		return array_merge($array1,$array2);
    }

}


