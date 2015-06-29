<?php namespace App\Utility\Authenticators;

use App\Models\User;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use Illuminate\Support\Facades\Request;


class TokenAuthenticator extends Authenticator
{
    protected $validated = false;
    protected $token;

    public function validate()
    {

        $this->token = Request::header('token');

        if (!$this->token)
            throw new ApiException(ApiExceptionType::$NO_TOKEN);

        $user = User::select(['id', 'roles'])->where('token', '=', $this->token)->first();

        if (!$user)
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

        $this->validated = true;
        $this->userId = $user->id;
        $this->userRoles = json_decode($user->roles);

    }

    public function returnUser()
    {
        return User::find($this->getUserId());
    }

    public function hasRole($role)
    {
        if(!$this->userRoles)
            return false;

        return (bool) in_array($role, $this->userRoles);
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