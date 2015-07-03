<?php namespace App\Http\Controllers;


use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use App\Utility\FacebookHelper;
use App\Utility\LinkedInHelper;
use Illuminate\Support\Facades\Request;

class SocialController extends ApiController
{

    public function facebook()
    {
        $networkToken = Request::get('token');

        if(!$networkToken)
            throw new ApiException(ApiExceptionType::$INVALID_INPUT);

        $networkToken = 'CAAGNMNZBgaowBALlZCDUloc3ujqjR7nkQCNwhdJGlUqnOW8zkRaDq4ynQM2lWJNbNjX7oi7S5HQBmMvGLfv4aAOsBPvRKCL6pxOk6NJ4ob1p347rjRozxen2nST9mRGmPOZClAj5Tn95NZAYyx1CL3r1eyff4eHrYkV0JsMtBfKMTJUJbBGcOWVBbyQUYl5TZAIpeRXOpbiE1cJklsPvHM3KsZCJLcGZCA8WtN5Cmcw7gZDZD';

        $facebook = new FacebookHelper($networkToken);
        $data = $facebook->getUser();

        $user = Shield::getUserModel();
        $user->importFromFacebook($data);

        return $this->respondWithStatus(true);
    }


    public function linkedin()
    {
        $networkToken = Request::get('token');

        if(!$networkToken)
            throw new ApiException(ApiExceptionType::$INVALID_INPUT);

        $networkToken = 'AQVZewKxPseuIgqU3l6_ivB1mPrM38ecQr_YlJ7o35lNNMKqeWZsIWEfltY-U9M8vjhuf_8K0Jc8dTkqBEMbd9_hpVZBubmqfTbHxuIxTVzCIAtDmYS4W8c1pLCc-zTwk3IT12McBtKPYPpO8ZtXPIcka4_VcOyXOIEJ414OwauEfZ4-siY';

        $linkedin = new LinkedInHelper($networkToken    );
        $data = $linkedin->getUser();

        $user = Shield::getUserModel();
        $user->importFromLinkedIn($data);

        return $this->respondWithStatus(true);
    }



}
