<?php namespace App\Http\Controllers;


use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\CloudHelper;
use App\Utility\Facades\Shield;
use Illuminate\Support\Facades\Config;

class ServicesController extends ApiController
{


    public function clean()
    {
        if (!Shield::hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

    }


    public function test()
    {

        $cloudHelper = new CloudHelper(Config::get('cfg.rackspace'));

        $cloudHelper->emptyContainer('UserImage/2');

//        $logs = Log::orderBy('id', 'asc')->take(10)->get();
//
//        foreach($logs as $log) {
//            echo $log->display() . "\n";
//        }

    }





}
