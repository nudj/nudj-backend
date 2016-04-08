<?php

namespace App\NSX300;

use Illuminate\Support\Facades\DB;

class NSX300_Skills {

    public static function get_skill_record_by_description_or_null($description){
        $answer = array();
        $dbresults = DB::select('select * from skills where name=?',[$description]);
        foreach($dbresults as $dbresult){
            return (array)$dbresult;        
        }
        return null;
        /*
            [
               "id"   => 11,
               "name" => "Database design"
            ]
        */
    }

    public static function get_skill_record_by_description_possibly_create_new($description){
        $record = self::get_skill_record_by_description_or_null($description);
        if($record) return $record;
        DB::insert('insert into skills (name) values (?)',[$description]);
        return self::get_skill_record_by_description_or_null($description);
    }

}
