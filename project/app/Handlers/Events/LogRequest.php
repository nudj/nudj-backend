<?php namespace App\Handlers\Events;

use App\Events\IncomingRequestEvent;
use App\Utility\Logger\Log;
use Illuminate\Support\Facades\Request;


class LogRequest
{

    public function handle(IncomingRequestEvent $event)
    {

        Log::create([
            'id' => Request::server('REQUEST_TIME_FLOAT'),

            'type' =>  Request::server('REQUEST_METHOD'),
            'from' => Request::server('REMOTE_ADDR'),

            'endpoint' =>  Request::path(),
            'token' => Request::header('token'),

            'get' =>  $_GET,
            'post' =>  Request::except(array_keys($_GET)),
        ]);


//        Deprecated file logging with Monolog
//
//        $handler = new RotatingFileHandler(storage_path().'/logs/requests.log', 0, Logger::INFO);
//        $logger = new Logger('requests');
//        $logger->pushHandler($handler);
//        $logger->addInfo('Incomming request', [
//            'id' => Request::server('REQUEST_TIME_FLOAT'),
//            'timestamp' => Request::server('REQUEST_TIME_FLOAT'),
//            'type' =>  Request::server('REQUEST_METHOD'),
//            'from' => Request::server('REMOTE_ADDR'),
//            'endpoint' =>  Request::path(),
//            'get' =>  $_GET,
//            'post' =>  Request::except(array_keys($_GET)),
//            'token' => Request::header('token'),
//            'headers' => getallheaders()
//        ]);

    }

}
