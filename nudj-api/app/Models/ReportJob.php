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

class ReportJob
{
    public static function report_job($reporter_user_id,$job_id){
        DB::select('insert into report_job (uuid,reporter_user_id,job_id) values (?,?,?)',[uniqid(),$reporter_user_id,$job_id]);	
    }
    public static function get_reported_jobids_for_primary_user($primary_user_id){
        $answer = [];
        $dbresults = DB::select('select job_id from report_job where reporter_user_id=?',[$primary_user_id]);
        foreach($dbresults as $dbresult){
            $answer[] = $dbresult->job_id;
        }
        return $answer;
    }
}


