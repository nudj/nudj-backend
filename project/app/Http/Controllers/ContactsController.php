<?php namespace App\Http\Controllers;


use App\Events\SendMessageToContactEvent;
use App\Models\Contact;
use App\Http\Requests;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use App\Utility\Transformers\ContactTransformer;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Lang;


class ContactsController extends ApiController
{

    public function index()
    {
        $me = Shield::getUserId();
        $items =  Contact::where('contact_of', '=', $me)->api()->orderBy('alias', 'asc')->get();

        return $this->respondWithItems($items, new ContactTransformer());
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

        Event::fire(new SendMessageToContactEvent($contact->phone, $message));

        return $this->respondWithStatus(true);
    }

}
