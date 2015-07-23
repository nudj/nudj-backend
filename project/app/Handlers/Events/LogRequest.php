<?php namespace App\Handlers\Events;

use App\Events\IncomingRequestEvent;
use App\Utility\Logger\ApiMongoFormatter;
use Illuminate\Support\Facades\Request;
use MongoClient;
use Monolog\Handler\MongoDBHandler;
use Monolog\Logger;
use Monolog\Processor\WebProcessor;

class LogRequest
{

    public function handle(IncomingRequestEvent $event)
    {

        $mongoHandler = new MongoDBHandler(
            new MongoClient(),
            'logger',
            'requests'
        );

        $mongoHandler->setFormatter(new ApiMongoFormatter());

        $logger = new Logger('requests');
        $logger->pushProcessor(new WebProcessor($_SERVER));


//        $status = $logger->addInfo('Incomming request', [
//            'id' => Request::server('REQUEST_TIME_FLOAT'),
//
//            'type' =>  Request::server('REQUEST_METHOD'),
//            'from' => Request::server('REMOTE_ADDR'),
//
//            'endpoint' =>  Request::path(),
//            'token' => Request::header('token'),
//
//            'get' =>  $_GET,
//            'post' =>  Request::except(array_keys($_GET)),
//
////            'headers' => getallheaders(),
//        ]);

       

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
