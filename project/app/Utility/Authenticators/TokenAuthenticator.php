<?php namespace App\Utility\Authenticators;


use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use Illuminate\Support\Facades\Request;


class TokenAuthenticator extends Authenticator
{
    protected $token;
    protected $validated = false;



    public function validate()
    {


        $this->token = Request::header('token');
        if (!$this->token)
            throw new ApiException(ApiExceptionType::$NO_TOKEN);


        $user = $this->user->findByToken($this->token);
        if (!$user)
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

        $this->validated = true;
        $this->userId = $user->id;

        $this->userRoles = json_decode($user->roles);

        return true;
    }


    public function getDigest()
    {

        if(!$this->validated)
            return null;

        return [
            'token' => $this->token,
            'user' => $this->userId,
            'roles' => $this->userRoles
        ];
    }
}