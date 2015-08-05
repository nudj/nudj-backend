<?php namespace App\Http\Controllers;

use App\Events\LoginUserEvent;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Models\Contact;
use App\Models\User;
use App\Http\Requests;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use App\Utility\Transformers\ContactTransformer;
use App\Utility\Transformers\JobTransformer;
use App\Utility\Transformers\UserTransformer;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;


class UsersController extends ApiController
{



    public function index()
    {
        $items = User::api()->paginate($this->limit);

        return $this->respondWithPagination($items, new UserTransformer());
    }


    public function show($id = null)
    {
        $id = $this->getPreparedId($id);

        $item = User::api()->findOrFail($id);

        return $this->respondWithItem($item, new UserTransformer());
    }


    public function store(CreateUserRequest $request)
    {

        $user = User::login($request->all());

        Event::fire(new LoginUserEvent($user->phone, $user->verification));

        return $this->respondWithStatus($user->id, ['code' => $user->verification]);
    }


    public function update($id = null)
    {

        if (is_int($id) && !Shield::hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

        $id = $this->getPreparedId($id);

        $user = User::find($id);

        if (!$user)
            throw new ApiException(ApiExceptionType::$USER_MISSING);

        $info = $user->edit(Input::all());

        return $this->respondWithStatus((bool) $info);
    }


    public function destroy($id = null)
    {
        if (is_int($id) && !Shield::hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

        $id = $this->getPreparedId($id);

        $status = User::destroy($id);

        return $this->respondWithStatus($status);
    }


    public function verify(VerifyUserRequest $request)
    {
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

        $item = User::min()->find($id);

        return $this->respondWithStatus($item);
    }


    public function contacts($id = null)
    {
        if (is_int($id) && !Shield::hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

        $id = $this->getPreparedId($id);

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
        $user = User::min()->findOrFail($id);

        $items = $user->favourites()->api()->paginate($this->limit);

        return $this->respondWithPagination($items, new UserTransformer());
    }


    public function favourite($id)
    {
        return $this->respondWithStatus(User::favourite($id, Shield::getUserId()));
    }


    public function unfavourite($id)
    {
        return $this->respondWithStatus(User::favourite($id, Shield::getUserId(), true));
    }

}
