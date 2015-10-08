<?php

namespace App\Http\Controllers\Desk\Auth;

use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;

class AuthController extends \Illuminate\Routing\Controller
{

    use AuthenticatesAndRegistersUsers, ValidatesRequests;

    protected $loginPath = '/auth/login';
    protected $redirectPath = '/dashboard';

    public function __construct()
    {

    }

}