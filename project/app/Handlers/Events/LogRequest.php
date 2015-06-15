<?php namespace App\Handlers\Events;

use App\Events\IncomingRequestEvent;
use App\Utility\Logger\ApiFormatter;

use Illuminate\Support\Facades\Request;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class LogRequest
{

    public function handle(IncomingRequestEvent $event)
    {

        $handler = new RotatingFileHandler(storage_path().'/logs/requests.log', 0, Logger::INFO);
        $handler->setFormatter(new ApiFormatter());

        $logger = new Logger('requests');
        $logger->pushHandler($handler);
        $logger->addInfo('Incomming request', [
            'id' => Request::server('REQUEST_TIME_FLOAT'),
            'timestamp' => Request::server('REQUEST_TIME_FLOAT'),
            'type' =>  Request::server('REQUEST_METHOD'),
            'from' => Request::server('REMOTE_ADDR'),
            'endpoint' =>  Request::path(),
            'get' =>  $_GET,
            'post' =>  Request::except(array_keys($_GET)),
            'token' => Request::header('token'),
            'headers' => getallheaders()
        ]);

    }

}
