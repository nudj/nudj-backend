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

        $networkToken = 'CAAGNMNZBgaowBAIZAkm29Gp3HZAneFb673FvjlQPUuJGlv60vQRLVLlIanMispuPvPUKZC71NKi36FTXSYGDZAysZBh0HnBOdHg0MfAJQQqXTmu1qU808GN95WAioVuGI4ORGVYf1Mr8yRZBkKaiYK52lxCAa89bnZAepKAMPIcPCWRJWZA05V9ZBqMAYyS06ZCcoOGglSlzN5jGdN3pZARJlOFsblZA2ipFFdR8ZBIq331U91QAZDZD';

        $facebook = new FacebookHelper($networkToken);
        $data = $facebook->getUser();
        $user = Shield::getUserModel();

        $user->importFromFacebook($data);

        return $this->respondWithStatus(true);
    }


    public function linkedin()
    {
        $networkToken = Request::get('token');
        $networkToken = 'AQVZewKxPseuIgqU3l6_ivB1mPrM38ecQr_YlJ7o35lNNMKqeWZsIWEfltY-U9M8vjhuf_8K0Jc8dTkqBEMbd9_hpVZBubmqfTbHxuIxTVzCIAtDmYS4W8c1pLCc-zTwk3IT12McBtKPYPpO8ZtXPIcka4_VcOyXOIEJ414OwauEfZ4-siY';

        $linkedin = new LinkedInHelper($networkToken    );
        $data = $linkedin->getUser();

        $user = Shield::getUserRepository();
        $user->importFromLinkedIn($data);

        return $this->respondWithStatus(true);
    }



}
