<?php namespace App\Models;

/*
	CREATE TABLE `block_user` (
	  `uuid` varchar(64) NOT NULL DEFAULT '',
	  `blocker_user_id` int(11) NOT NULL,
	  `blocked_user_id` int(11) NOT NULL,
	  `operation_datetime` datetime NOT NULL,
	  PRIMARY KEY (`uuid`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

use DB;

class UsersBlocked
{
    public static function block_user($blocker_user_id,$blocked_user_id){
        DB::insert('insert into users_blocked (uuid,blocker_user_id,blocked_user_id) values (?,?,?)',[uniqid(),$blocker_user_id,$blocked_user_id]);	
    }

    public static function unblock_user($blocker_user_id,$blocked_user_id){
        DB::delete('delete from users_blocked where blocker_user_id=?  and blocked_user_id=?',[$blocker_user_id,$blocked_user_id]);	
    }

    // UsersBlocked::get_blocked_userids_for_primary_user($primary_user_id)
    public static function get_blocked_userids_for_primary_user($primary_user_id){
        $answer = [];
        $dbresults = DB::select('select blocked_user_id from users_blocked where blocker_user_id=?',[$primary_user_id]);
        foreach($dbresults as $dbresult){
            $answer[] = $dbresult->blocked_user_id;
        }
        return $answer;
    }
}


