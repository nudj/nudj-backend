<?php namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Skill;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Facades\Shield;
use Elasticsearch\Client;
use Illuminate\Support\Facades\Config;

class ServicesController extends ApiController
{


    public function clean()
    {
        if (!Shield::hasRole('admin'))
            throw new ApiException(ApiExceptionType::$UNAUTHORIZED);

    }



}
