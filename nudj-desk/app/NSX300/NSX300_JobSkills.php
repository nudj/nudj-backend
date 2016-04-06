<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_JobSkills {

    public static function job_skills_as_integers_for_job_identifier($job_identifier){
        $answer = array();
        $dbresults = DB::select('select * from job_skill where job_id=?',[$job_identifier]);
        foreach($dbresults as $dbresult){
            $answer[] = (int)$dbresult->skill_id;        
        }
        return $answer; 
    }

    public static function skill_identifier_to_description_or_null($identifier){
        $dbresults = DB::select('select * from skills where id=?',[$identifier]);
        foreach($dbresults as $dbresult){
            return (string)$dbresult->name;        
        }
        return null;        
    }

    public static function array_of_job_skill_identifiers_to_descriptions($identifiers){
        $names = array_map(function($identifier){
            return self::skill_identifier_to_description_or_null($identifier);
        },$identifiers);
        $names = array_filter($names);
        return $names;
    }

    public static function job_skills_as_descriptions_for_job_identifier($job_identifier){
        $skills_ids = self::job_skills_as_integers_for_job_identifier($job_identifier);
        $descriptions = self::array_of_job_skill_identifiers_to_descriptions($skills_ids);
        return $descriptions;
    }

}
