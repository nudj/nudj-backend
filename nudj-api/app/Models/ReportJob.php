<?php namespace App\Models;

/*
CREATE TABLE `report_job` (
  `uuid` varchar(64) NOT NULL DEFAULT '',
  `reporter_user_id` int(11) NOT NULL,
  `job_id` int(11) NOT NULL,
  `operation_datetime` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
*/

use DB;

class ReportJob extends ApiModel
{
    public static function report_job($reporter_user_id,$job_id){
        DB::select('insert into report_job (uuid,reporter_user_id,job_id) values (?,?,?)',[uniqid(),$reporter_user_id,$job_id]);	
    }
}


