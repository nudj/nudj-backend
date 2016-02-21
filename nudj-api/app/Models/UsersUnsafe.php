<?php namespace App\Models;

use App\Models\UsersBlocked;
use App\Models\UsersReported;

class UsersUnsafe
{
	// UsersUnsafe::unsafe_userids_for_primary_user($primary_userid)
    public static function unsafe_userids_for_primary_user($primary_userid){
    	$array1 = UsersReported::get_reported_userids_for_primary_user($primary_userid);
    	$array2 = UsersBlocked::get_blocked_userids_for_primary_user($primary_userid);
		return array_merge($array1,$array2);
    }

}


