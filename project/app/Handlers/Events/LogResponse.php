<?php namespace App\Handlers\Events;


use App\Events\ReturnResponseEvent;
use App\Utility\Logger\Log;
use Illuminate\Support\Facades\Request;

class LogResponse
{

    public function handle(ReturnResponseEvent $event)
    {

        $log = Log::where('id', '=', Request::server('REQUEST_TIME_FLOAT'))->first();

        if(!$log)
            return false;

        $log->response = json_encode([
            'timestamp' => microtime(true),
            'body' => $event->response
        ]);

        return $log->save();
    }


}
