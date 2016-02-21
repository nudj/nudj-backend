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

class BlockUser
{
    public static function block_user($blocker_user_id,$blocked_user_id){
        DB::select('insert into block_user (uuid,blocker_user_id,blocked_user_id) values (?,?,?)',[uniqid(),$blocker_user_id,$blocked_user_id]);	
    }
}


