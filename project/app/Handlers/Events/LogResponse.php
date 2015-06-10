<?php namespace App\Handlers\Events;

use App\Events\IncomingRequestEvent;
use App\Events\ReturnResponseEvent;
use App\Utility\Logger\ApiFormatter;

use Illuminate\Support\Facades\Request;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class LogResponse
{

    public $authenticator;

    public function handle(ReturnResponseEvent $event)
    {

        $handler = new RotatingFileHandler(storage_path().'/logs/responses.log', 0, Logger::INFO);
        $handler->setFormatter(new ApiFormatter());

        $logger = new Logger('responses');
        $logger->pushHandler($handler);
        $logger->addInfo('Response', [
            'id' => Request::server('REQUEST_TIME_FLOAT'),
            'timestamp' => microtime(true),
            'response' => $event->response
        ]);

    }

}
