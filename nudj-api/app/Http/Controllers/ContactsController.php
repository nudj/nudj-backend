<?php namespace App\Http\Controllers;

use App\Events\SendMessageToContactEvent;

use App\Models\Contact;
use App\Models\RobynMcGirl;
use App\Models\UsersUnsafe;

use App\Http\Requests;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use App\Utility\Transformers\ContactTransformer;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;

use Log;

class ContactsController extends ApiController
{

    public function index()
    {
        $me = Shield::getUserId();

        // ----------------------------------------------------------------
        // Marker: 5c9e67aa-8009-41e0-9f15-d49190d87a7a

        if($me!=1){
        	RobynMcGirl::add_robyn_as_contact_of_this_user_if_not_already($me);
	        RobynMcGirl::add_this_person_as_contact_of_robyn_if_not_already($me);
        }

        // ----------------------------------------------------------------

        $items = Contact::where('contact_of', '=', $me)
	        ->whereNotIn('id', UsersUnsafe::unsafe_userids_for_primary_user($me))
        	->api()
        	->orderBy('alias', 'asc')
        	->get();

        $answer = $this->respondWithItems($items, new ContactTransformer());

        return $answer;
    }

    public function update($id = null)
    {
        $contact = Contact::findIfOwnedBy($id, Shield::getUserId());

        if (!$contact)
            throw new ApiException(ApiExceptionType::$NOT_FOUND);

        $status = $contact->edit(Input::all());

        return $this->respondWithStatus($status);
    }

    public function destroy($id = null)
    {
        $contact = Contact::findIfOwnedBy($id, Shield::getUserId());

        if (!$contact)
            throw new ApiException(ApiExceptionType::$NOT_FOUND);
        
        $status = $contact->delete();

        return $this->respondWithStatus($status);
    }

    public function invite($id = null)
    {

        $contact = Contact::findIfOwnedBy($id, Shield::getUserId());

        if (!$contact)
            throw new ApiException(ApiExceptionType::$NOT_FOUND);

        $message = Lang::get('sms.invite', ['name' => Shield::getUserValue('name'), 'link' => 'http://api.nudj.co']);

        Event::fire(new SendMessageToContactEvent($contact->phone, $contact->country_code, $message));

        return $this->respondWithStatus(true);
    }

}
