<?php namespace App\Handlers\Events;


use App\Events\ReturnResponseEvent;
use App\Utility\Logger\Log;
use Illuminate\Support\Facades\Request;

class LogResponse
{

    public function handle(ReturnResponseEvent $event)
    {

        $log = Log::find(Request::server('REQUEST_TIME_FLOAT'));

        $log->response = [
            'timestamp' => microtime(true),
            'body' => $event->response
        ];

        $log->save();
    }

}
