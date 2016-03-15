<?php namespace App\Models;

/*
	
	15th March 2016.

	This class exists to enable some special behaviours ('hack') that Robyn requested.

	See: 58810d88-1ba3-48e4-9a78-5e4ccf8abca4
		// This was added to prevent the deletion of Robyn's user account

	See: 5c9e67aa-8009-41e0-9f15-d49190d87a7a
		// RobynMcGirl::add_robyn_as_contact_of_this_user_if_not_already($me);

*/

use DB;
use Log;

class RobynMcGirl
{

	public static function get_robyn_or_null(){
		$dbresults = DB::select('select * from users where email=? and deleted_at is NULL',['robyn@nudj.co']);
		foreach($dbresults as $dbresult){
			return $dbresult;			
		}	
		return null;
	}		

	public static function add_robyn_as_contact_of_this_user_if_not_already($target_user_id){

		$items = Contact::where('contact_of', '=', $target_user_id)->get();

		foreach($items as $item){
			if($item->alias=='Robyn McGirl'){
				return null;
			}
		}

        $contact = new Contact();
        $contact->contact_of   = $target_user_id;
        $contact->user_id      = 1;
        $contact->alias        = 'Robyn McGirl';
        $contact->phone        = '+447920549291';
        $contact->country_code = 'GB';
        $contact->suspicious   = 0;
        $contact->save();

	}

}


