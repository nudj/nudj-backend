<?php namespace App\Utility\Authenticators\Drivers;



use app\Utility\Contracts\ShieldAuthDriverContract;
use Illuminate\Support\Facades\Session;

class SessionAuthDriver implements ShieldAuthDriverContract {


    public function getToken()
    {
        return Session::has('token') ? Session::get('token') : null;
    }

}