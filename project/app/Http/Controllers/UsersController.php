<?php namespace App\Http\Controllers;

use App\Events\LoginUserEvent;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\VerifyUserRequest;
use App\Models\User;
use App\Http\Requests;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\FacebookHelper;
use App\Utility\LinkedInHelper;
use App\Utility\Transformers\ContactTransformer;
use App\Utility\Transformers\JobTransformer;
use App\Utility\Transformers\UserTransformer;
use Guzzle\Http\Client;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Input;


class UsersController extends ApiController
{

    public function social()
    {
//        $facebook = new FacebookHelper('CAAJwHrIFdrsBAJszlMZCkyJOr0SJ1sHpxGRZBcMVjGqMhaltPZABDQCnYLFdJvv2KMBQWupSZCi5hQg6GyELsnvyikH81y5gG5vpAJPMFFTfvRUNIFWkG8p34PzTQvvCZAAuOZAZAGbdubmL9Wp5oirX2KxlQQXyb69QmEnCCjlrUrh17qT1swexGrtmIKygQ6CzZCiax7yDb4BF2UHF8ItAeUkM44ZBt3kxfHYLbSxPZCngZDZD');
//        $user = $facebook->getUser();
//        echo $user->name;

        $token = 'AQVZewKxPseuIgqU3l6_ivB1mPrM38ecQr_YlJ7o35lNNMKqeWZsIWEfltY-U9M8vjhuf_8K0Jc8dTkqBEMbd9_hpVZBubmqfTbHxuIxTVzCIAtDmYS4W8c1pLCc-zTwk3IT12McBtKPYPpO8ZtXPIcka4_VcOyXOIEJ414OwauEfZ4-siY';
        $linkedin = new LinkedInHelper($token);
        $user = $linkedin->getUser();
        $user->name;

        die('end.');
    }


    public function index()
    {
        $items = User::api()->paginate($this->limit);

        return $this->respondWithPagination($items, new UserTransformer());
    }


    public function show($id = null)
    {
        $id = $this->getPreparedId($id);

        $item = User::api()->find($id);

        if (!$item)
            throw new ApiException(ApiExceptionType::$USER_MISSING);

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

        if (is_int($id) && !$this->authenticator->hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

        $id = $this->getPreparedId($id);

        $user = User::find($id);

        if (!$user)
            throw new ApiException(ApiExceptionType::$USER_MISSING);

        $info = $user->edit(Input::all());

        return $this->respondWithItem($info, new UserTransformer());
    }


    public function destroy($id = null)
    {
        if (is_int($id) && !$this->authenticator->hasRole('admin'))
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
        if (is_int($id) && !$this->authenticator->hasRole('admin'))
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
        if (is_int($id) && !$this->authenticator->hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

        $id = $this->getPreparedId($id);

        $user = User::min()->find($id);

        if (!$user)
            throw new ApiException(ApiExceptionType::$USER_MISSING);

        $items = $user->favourites()->api()->paginate($this->limit);
        return $this->respondWithPagination($items, new JobTransformer());
    }

}
