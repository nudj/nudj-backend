<?php namespace App\Http\Controllers;


use App\Utility\FacebookHelper;
use App\Utility\LinkedInHelper;

class SocialController extends ApiController
{

    public function facebook()
    {
        $facebook = new FacebookHelper('CAAJwHrIFdrsBAJszlMZCkyJOr0SJ1sHpxGRZBcMVjGqMhaltPZABDQCnYLFdJvv2KMBQWupSZCi5hQg6GyELsnvyikH81y5gG5vpAJPMFFTfvRUNIFWkG8p34PzTQvvCZAAuOZAZAGbdubmL9Wp5oirX2KxlQQXyb69QmEnCCjlrUrh17qT1swexGrtmIKygQ6CzZCiax7yDb4BF2UHF8ItAeUkM44ZBt3kxfHYLbSxPZCngZDZD');
        $user = $facebook->getUser();
        echo $user->name;

    }

    public function linkedin()
    {
        $token = 'AQVZewKxPseuIgqU3l6_ivB1mPrM38ecQr_YlJ7o35lNNMKqeWZsIWEfltY-U9M8vjhuf_8K0Jc8dTkqBEMbd9_hpVZBubmqfTbHxuIxTVzCIAtDmYS4W8c1pLCc-zTwk3IT12McBtKPYPpO8ZtXPIcka4_VcOyXOIEJ414OwauEfZ4-siY';
        $linkedin = new LinkedInHelper($token);
        $user = $linkedin->getUser();
        echo $user->firstName;
    }



}
