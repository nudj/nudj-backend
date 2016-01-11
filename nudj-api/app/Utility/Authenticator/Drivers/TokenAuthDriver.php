<?php namespace App\Utility\Authenticators\Drivers;



use app\Utility\Contracts\ShieldAuthDriverContract;
use Illuminate\Support\Facades\Request;

class TokenAuthDriver implements ShieldAuthDriverContract {


    public function getToken()
    {
        return Request::get('token') ?: null;
    }
    
}