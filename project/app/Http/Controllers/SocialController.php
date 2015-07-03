<?php namespace App\Http\Controllers;


use App\Utility\Facades\Shield;
use App\Utility\FacebookHelper;
use App\Utility\LinkedInHelper;
use Illuminate\Support\Facades\Request;

class SocialController extends ApiController
{

    public function facebook()
    {
        $networkToken = Request::get('token');
        $networkToken = 'CAAJwHrIFdrsBAJszlMZCkyJOr0SJ1sHpxGRZBcMVjGqMhaltPZABDQCnYLFdJvv2KMBQWupSZCi5hQg6GyELsnvyikH81y5gG5vpAJPMFFTfvRUNIFWkG8p34PzTQvvCZAAuOZAZAGbdubmL9Wp5oirX2KxlQQXyb69QmEnCCjlrUrh17qT1swexGrtmIKygQ6CzZCiax7yDb4BF2UHF8ItAeUkM44ZBt3kxfHYLbSxPZCngZDZD';

        $facebook = new FacebookHelper($networkToken);
        $data = $facebook->getUser();

        $user = Shield::getUserRepository();
        $user->importFromFacebook($data);
    }


    public function linkedin()
    {
        $networkToken = Request::get('token');
        $networkToken = 'AQVZewKxPseuIgqU3l6_ivB1mPrM38ecQr_YlJ7o35lNNMKqeWZsIWEfltY-U9M8vjhuf_8K0Jc8dTkqBEMbd9_hpVZBubmqfTbHxuIxTVzCIAtDmYS4W8c1pLCc-zTwk3IT12McBtKPYPpO8ZtXPIcka4_VcOyXOIEJ414OwauEfZ4-siY';

        $linkedin = new LinkedInHelper($networkToken    );
        $data = $linkedin->getUser();

        $user = Shield::getUserRepository();
        $user->importFromLinkedIn($data);

    }



}
