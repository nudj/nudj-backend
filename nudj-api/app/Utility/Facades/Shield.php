<?php namespace App\Utility\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \App\Utility\Authenticator\Shield
 */

class Shield extends Facade {

    protected static function getFacadeAccessor() { return 'shield'; }

}