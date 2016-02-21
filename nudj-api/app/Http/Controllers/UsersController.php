<?php namespace App\Http\Controllers;

use App\Events\LoginUserEvent;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Http\Requests;

use App\Models\Contact;
use App\Models\User;
use App\Models\BlockUser;
use App\Models\ReportUser;
use App\Models\UnsafeUsers;

use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use App\Utility\Transformers\ContactTransformer;
use App\Utility\Transformers\JobTransformer;
use App\Utility\Transformers\UserSortedTransformer;
use App\Utility\Transformers\UserTransformer;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;

use DB;

class UsersController extends ApiController
{

    public function index()
    {
    	$me = Shield::getUserId();
        $items = User::whereNotIn('id', UnsafeUsers::unsafe_userids_for_primary_user($me))
        	->paginate($this->limit);
        return $this->respondWithPagination($items, new UserTransformer());
    }

    public function show($id = null)
    {
        $id = $this->getPreparedId($id);
        // Note: This function is defined in ApiController and returns the id of the current user
        // The given parameter $id could be null of equal to 'me'
        // In either case, the current user id needs to be extracted by Shield::getUserId()
        // See uuid: 641f86e1-5fd6-412e-92e3-38603cd8ceb0

        $item = User::api()->findOrFail($id);
        // Ok so at this point we have a user we are going to send it back to the client, but before
        // doing so we need to transform it because as at it currently is we cannot directly JSON serialize it.

        // To convert/transform a user into a json object we use a class called UserTransformer()
        // in App\Utility\Transformers\UserTransformer;
        // In other circumstances one would make this functionality a method of the User class, but it
        // is far better to make it as a separate class.

		// respondWithItem is defined in ApiController
		// It takes an $item and the transformer associated with that item
		// and returns the json serialization of
		/*
			[
				"data" => $transformer->transform($item)
			]
		*/

        return $this->respondWithItem($item, new UserTransformer());

    }

    public function store(CreateUserRequest $request)
    {

        // -----------------------------------------
        // No token required
        // -----------------------------------------

        $user = User::login($request->all());

        Event::fire(new LoginUserEvent($user->phone, $user->country_code, $user->verification));

        return $this->respondWithStatus($user->id);
    }

    public function update($id = null)
    {

        if (is_int($id) && !Shield::hasRole('admin')){
			// id is either: null, an int or 'me'
			// We do not want regular users to update other users details, unless being an admin
			// Therefore we throw an exception if the id is an int but the current user is not admin 
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);
        }

        $id = $this->getPreparedId($id);
        // Note: This function is defined in ApiController and returns the id of the current user
        // The given parameter $id could be null of equal to 'me'
        // In either case, the current user id needs to be extracted by Shield::getUserId()
        // See uuid: 641f86e1-5fd6-412e-92e3-38603cd8ceb0

        $user = User::find($id);

        if (!$user)
            throw new ApiException(ApiExceptionType::$USER_MISSING);

        $info = $user->edit(Input::all());

        return $this->respondWithStatus((bool) $info);
    }

    public function destroy($id = null)
    {
        if (is_int($id) && !Shield::hasRole('admin')){
			// id is either: null, an int or 'me'
			// We do not want regular users to delete other users, unless being an admin
			// Therefore we throw an exception if the id is an int but the current user is not admin 
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);
        }

        $id = $this->getPreparedId($id);
        // Note: This function is defined in ApiController and returns the id of the current user
        // The given parameter $id could be null of equal to 'me'
        // In either case, the current user id needs to be extracted by Shield::getUserId()
        // See uuid: 641f86e1-5fd6-412e-92e3-38603cd8ceb0

        $status = User::destroy($id);

        return $this->respondWithStatus($status);
    }

    public function verify(VerifyUserRequest $request)
    {

        // -----------------------------------------
        // No token required
        // -----------------------------------------

        $user = User::verify($request->all());

        if (!$user)
            throw new ApiException(ApiExceptionType::$VERIFICATION_ERROR);

        Contact::syncContactOf($user->id, $user->phone);

        return $this->respondWithStatus(true, [
            'id' => $user->id,
            'token' => $user->token,
            'completed' => (bool)$user->completed
        ]);

    }

    public function exists($id = null)
    {

        // -----------------------------------------
        // No token required
        // -----------------------------------------

        $item = User::min()->find($id);

        return $this->respondWithStatus($item);
    }

    public function contacts($id = null)
    {
        if (is_int($id) && !Shield::hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

        $id = $this->getPreparedId($id);
        // Note: This function is defined in ApiController and returns the id of the current user
        // The given parameter $id could be null of equal to 'me'
        // In either case, the current user id needs to be extracted by Shield::getUserId()
        // See uuid: 641f86e1-5fd6-412e-92e3-38603cd8ceb0

        $user = User::min()->find($id);

        if (!$user)
            throw new ApiException(ApiExceptionType::$USER_MISSING);

        $items = $user->contacts()->api()->paginate($this->limit);
        return $this->respondWithPagination($items, new ContactTransformer());
    }

    public function favourites($id = null)
    {
        if (is_int($id) && !Shield::hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

        $id = $this->getPreparedId($id);
        // Note: This function is defined in ApiController and returns the id of the current user
        // The given parameter $id could be null of equal to 'me'
        // In either case, the current user id needs to be extracted by Shield::getUserId()
        // See uuid: 641f86e1-5fd6-412e-92e3-38603cd8ceb0

        $user = User::min()->findOrFail($id);

        $items = $user->favourites()->api()->paginate($this->limit);

        return $this->respondWithPagination($items, new UserSortedTransformer());
    }

    public function favourite($id)
    {
        return $this->respondWithStatus(User::favourite($id, Shield::getUserId()));
    }

    public function unfavourite($id)
    {
        return $this->respondWithStatus(User::favourite($id, Shield::getUserId(), true));
    }

    public function reportuser($reporteduserid)
    {
    	$me = Shield::getUserId();
		ReportUser::report_user($me,$reporteduserid);
    	return $this->respondWithStatus(true);
    }

    public function blockuser($blockeduserid)
    {
    	$me = Shield::getUserId();
		BlockUser::block_user($me,$blockeduserid);
    	return $this->respondWithStatus(true);
    }

}
