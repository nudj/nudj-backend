<?php namespace App\Handlers\Events;

use App\Events\IncomingRequestEvent;
use App\Utility\Logger\ApiMongoFormatter;
use Illuminate\Support\Facades\Request;
use MongoClient;
use Monolog\Handler\MongoDBHandler;
use Monolog\Logger;

class LogRequest
{

    public function handle(IncomingRequestEvent $event)
    {

        $handler = new MongoDBHandler(
            new MongoClient(),
            'logger',
            'requests'
        );

        $handler->setFormatter(new ApiMongoFormatter());

        $logger = new Logger('requests');
        $status = $logger->addInfo('Incomming request', [
            'id' => Request::server('REQUEST_TIME_FLOAT'),

            'type' =>  Request::server('REQUEST_METHOD'),
            'from' => Request::server('REMOTE_ADDR'),

            'endpoint' =>  Request::path(),
            'token' => Request::header('token'),

            'get' =>  $_GET,
            'post' =>  Request::except(array_keys($_GET)),

//            'headers' => getallheaders(),
        ]);

        var_dump($status);

//        $logger->pushHandler($handler);


//        $handler = new RotatingFileHandler(storage_path().'/logs/requests.log', 0, Logger::INFO);
//
//
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
