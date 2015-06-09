<?php namespace App\Utility\Authenticators;

use App\Models\User;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use Illuminate\Support\Facades\Request;




class TokenAuthenticator extends Authenticator
{

    protected $token;

    public function validate()
    {
        echo $_SERVER['REMOTE_ADDR'] . '-' . $_SERVER['SERVER_ADDR'];
        
        if($_SERVER['REMOTE_ADDR'] == $_SERVER['SERVER_ADDR']) {
            $this->token = Request::input('token');
        } else {
            $this->token = Request::header('token');
        }

        if (!$this->token)
            throw new ApiException(ApiExceptionType::$NO_TOKEN);

        $user = User::select(['id', 'roles'])->where('token', '=', $this->token)->first();

        if (!$user)
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

        $this->userId = $user->id;
        $this->userRoles = json_decode($user->roles);

    }

    public function hasRole($role)
    {
        return (bool) in_array($role, $this->userRoles);
    }

    public function getDigest() {
        return [
          'token' => $this->token,
          'user' => $this->userId,
          'roles' => $this->userRoles
        ];
    }
}