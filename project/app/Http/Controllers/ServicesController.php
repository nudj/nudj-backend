<?php namespace App\Http\Controllers;


use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use App\Utility\Logger\Log;

class ServicesController extends ApiController
{


    public function clean()
    {
        if (!Shield::hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

    }


    public function test()
    {


        $logs = Log::all();


        foreach($logs as $log) {
            $log->response = 'asd';
            $log->save();
            echo $log->display();
        }

    }





}
