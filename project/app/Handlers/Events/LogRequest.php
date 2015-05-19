<?php namespace App\Handlers\Events;

use App\Events\IncomingRequestEvent;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldBeQueued;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Logger;

class LogRequest
{

    public function handle(IncomingRequestEvent $event)
    {

        $log = new Logger('requests');
        $log->pushHandler(new RotatingFileHandler(storage_path() . '/logs/requests.log', Logger::INFO));

        $log->addInfo($event->name, $event->data);

    }

}
