<?php namespace App\Handlers\Events;


use App\Events\ReturnResponseEvent;
use App\Utility\Logger\Log;
use Illuminate\Support\Facades\Request;

class LogResponse
{

    public function handle(ReturnResponseEvent $event)
    {

        print_r($event->response);

        $log = Log::find(Request::server('REQUEST_TIME_FLOAT'));

        print_r($log);

//        $log->response = json_encode([
//            'timestamp' => microtime(true),
//            'body' => $event->response
//        ]);
//
//        $log->save();
    }

}
