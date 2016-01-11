<?php namespace App\Http\Controllers;

use App\Models\User;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use App\Utility\FacebookHelper;
// ---------------------------------------------------------------------
// TODO: The below is commented out waiting to be deleted
// use App\Utility\LinkedInHelper;
// ---------------------------------------------------------------------
use Illuminate\Support\Facades\Request;

/*

This controller performs the login and logout of users identified by a social network
It used to support Facebook and LinKedIn, but the LinkedIn code was been commented out 
on 2016.01.04, because we no longer support LinkedIn authentication.

*/

class SocialController extends ApiController
{

    public function facebook()
    {
        $networkToken = Request::get('token');

        if(!$networkToken)
            throw new ApiException(ApiExceptionType::$INVALID_INPUT);

        $facebook = new FacebookHelper($networkToken);
        $data = $facebook->getUser();

        $user = Shield::getUserModel();
        /*
            Note: The function importFromFacebook is defined in trait Social
        */
        $user->importFromFacebook($data);

        $user->facebook_token = $networkToken;
        $user->save();

        return $this->respondWithStatus(true);
    }

    public function disconnectFacebook()
    {
        $user = User::find(Shield::getUserId());
        $user->facebook_token = null;
        $user->save();

        return $this->respondWithStatus(true);
    }

    // ---------------------------------------------------------------------
    // TODO: The below is commented out waiting to be deleted
    /*
    public function linkedin()
    {
        $networkToken = Request::get('token');

        if(!$networkToken)
            throw new ApiException(ApiExceptionType::$INVALID_INPUT);

        $linkedin = new LinkedInHelper($networkToken);
        $data = $linkedin->getUser();

        $user = Shield::getUserModel();
        $user->importFromLinkedIn($data);

        $user->linkedin_token = $networkToken;
        $user->save();

        return $this->respondWithStatus(true);
    }

    public function disconnectLinkedin()
    {
        $user = User::find(Shield::getUserId());
        $user->linkedin_token = null;
        $user->save();

        return $this->respondWithStatus(true);
    }
    */
    // ---------------------------------------------------------------------

}
