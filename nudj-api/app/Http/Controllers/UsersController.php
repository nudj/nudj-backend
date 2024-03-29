<?php namespace App\Http\Controllers;

use App\Events\LoginUserEvent;

use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Http\Requests;

use App\Models\Contact;
use App\Models\User;
use App\Models\UsersBlocked;
use App\Models\UsersReported;
use App\Models\UsersUnsafe;

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
        $items = User::whereNotIn('id', UsersUnsafe::unsafe_userids_for_primary_user($me))
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


        // ------------------------------------------------------
        // 15th March 2016

        // Marker: 58810d88-1ba3-48e4-9a78-5e4ccf8abca4

        // This was added to prevent the deletion of Robyn's user account, which was originally user 1.
        // The other part of this hack is the introduction today of the RobynMcGirl model class.

        if($id==1){
        	return $this->respondWithStatus(true);
        }

        // ------------------------------------------------------

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

        $me = Shield::getUserId();
        $items = $user->contacts()
            ->whereNotIn('id', UsersUnsafe::unsafe_userids_for_primary_user($me))
            ->api()
            ->paginate($this->limit);
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

        $me = Shield::getUserId();
        $items = $user->favourites()
            ->whereNotIn('id', UsersUnsafe::unsafe_userids_for_primary_user($me))
            ->api()
            ->paginate($this->limit);

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

        if($reporteduserid==$me){
            throw new ApiException(ApiExceptionType::$BAD_REQUEST);
        }

		UsersReported::report_user($me,$reporteduserid);
    	return $this->respondWithStatus(true);
    }

    public function blockuser($blockeduserid)
    {
        $me = Shield::getUserId();

        if($blockeduserid==$me){
            throw new ApiException(ApiExceptionType::$BAD_REQUEST); // Preventing a user to block themselves
        }

        UsersBlocked::block_user($me,$blockeduserid);
        return $this->respondWithStatus(true);
    }

    public function unblockuser($blockeduserid)
    {
        $me = Shield::getUserId();
        UsersBlocked::unblock_user($me,$blockeduserid);
        return $this->respondWithStatus(true);
    }

    public function unsafe()
    {
    	$me = Shield::getUserId();
        $ids = UsersUnsafe::unsafe_userids_for_primary_user($me);
        return $this->respondWithStatus(true, ['ids' => $ids]);
    }

}
