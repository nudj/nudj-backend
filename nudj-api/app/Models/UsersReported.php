<?php namespace App\Models;

/*
CREATE TABLE `report_user` (
  `uuid` varchar(64) NOT NULL DEFAULT '',
  `reporter_user_id` int(11) NOT NULL,
  `reported_user_id` int(11) NOT NULL,
  `operation_datetime` datetime NOT NULL,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

use DB;

class UsersReported
{
    public static function report_user($reporter_user_id,$reported_user_id){
        DB::select('insert into users_reported (uuid,reporter_user_id,reported_user_id) values (?,?,?)',[uniqid(),$reporter_user_id,$reported_user_id]);	
    }

    // UsersReported::get_reported_userids_for_primary_user($primary_user_id)
    public static function get_reported_userids_for_primary_user($primary_user_id){
        $answer = [];
        $dbresults = DB::select('select reported_user_id from users_reported where reporter_user_id=?',[$primary_user_id]);
        foreach($dbresults as $dbresult){
            $answer[] = $dbresult->reported_user_id;
        }
        return $answer;
    }

}


