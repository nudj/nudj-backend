<?php namespace App\Models;

/*
    The original version of this class is maintained in nudj-desk. 
    Other versions are just copies.
*/

use DB;

class Text1 {

    // Text1::get_record_by_reference_or_null($reference)
    public static function get_record_by_reference_or_null($reference){
        $dbresults = DB::select('select * from text1 where reference=?',[$reference]);
        foreach($dbresults as $dbresult){
            return (array)$dbresult;          
        }
        return null;
    }

    // Text1::get_text_by_reference_or_empty_string($reference)
    public static function get_text_by_reference_or_empty_string($reference){
        $record = Text1::get_record_by_reference_or_null($reference);
        if(is_null($record)){
            return '';
        }
        return $record['text'];
    }

    // Text1::set_text($reference,$text)
    public static function set_text($reference,$text){
        // Here we need to check if the reference already exists or not
        $data = self::get_record_by_reference_or_null($reference);
        if($data){
            // Here we do an update
            DB::select('update text1 set text=?, last_update_datetime=? where reference=?',[$text,date("Y-m-d H:i:s",time()),$reference]);
        }else{
            // Here we do an insert
            DB::select('insert into text1 (text,reference,last_update_datetime) values (?,?,?)',[$text,$reference,date("Y-m-d H:i:s",time())]);
        }
    }

}
