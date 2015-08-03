<?php namespace App\Http\Controllers;


use App\Models\Contact;
use App\Http\Requests;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use App\Utility\Transformers\ContactTransformer;
use Illuminate\Support\Facades\Input;


class ContactsController extends ApiController
{

    public function index($filter = null)
    {
        $me = Shield::getUserId();

        switch ($filter) {
            case 'favourited' :
                $items =  Contact::where('favourite', '=', true)
                        ->where('contact_of', '=', $me)
                        ->api()->orderBy('alias', 'asc')->get();
                break;
            default:
                $items =  Contact::where('contact_of', '=', $me)
                    ->api()->orderBy('alias', 'asc')->get();
        }

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

}
