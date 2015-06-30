<?php namespace App\Utility\Facades;

use Illuminate\Support\Facades\Facade;

class Authenticate extends Facade {

    protected static function getFacadeAccessor() { return 'authenticate'; }

}