<?php namespace App\Handlers\Events;


use App\Events\ReturnResponseEvent;
use App\Utility\Logger\Log;
use Illuminate\Support\Facades\Request;

class LogResponse
{

    public function handle(ReturnResponseEvent $event)
    {

        $log = Log::where('id', '=', Request::server('REQUEST_TIME_FLOAT'))->first();

        var_dump($log);

        if(!$log)
            return false;
        print_r($log);

        $log->response = json_encode([
            'timestamp' => microtime(true),
            'body' => $event->response
        ]);

        return $log->save();
    }


}
