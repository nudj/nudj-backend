<?php namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Skill;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use App\Utility\Logger\Log;
use App\Utility\Util;
use Elasticsearch\Client;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class ServicesController extends ApiController
{


    public function clean()
    {
        if (!Shield::hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

    }


    public function test()
    {
//        $logs = DB::connection('mongodb')->collection('logs')->get();

        $logs = Log::all();

        foreach($logs as $log)
            $log->display();
    }





}
