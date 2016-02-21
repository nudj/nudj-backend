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

class ReportUser
{
    public static function report_user($reporter_user_id,$reported_user_id){
        DB::select('insert into report_user (uuid,reporter_user_id,reported_user_id) values (?,?,?)',[uniqid(),$reporter_user_id,$reported_user_id]);	
    }
}


