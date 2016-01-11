<?php namespace App\Handlers\Events;

use App\Events\IncomingRequestEvent;
use App\Utility\Logger\Log;
use Illuminate\Support\Facades\Request;

/*
	This handler receives IncomingRequestEvent
	PASCAL: 
		Where is the logging happening ? (Mongo ?)
		What fires it ?
			-> ApiController::__construct() 
*/

class LogRequest
{

    public function handle(IncomingRequestEvent $event)
    {
        Log::create([
            'id'       => Request::server('REQUEST_TIME_FLOAT'),

            'type'     => (string)Request::server('REQUEST_METHOD'),
            'from'     => (string)Request::server('REMOTE_ADDR'),

            'endpoint' => (string)Request::path(),
            'token'    => (string)Request::header('token'),

            'get'      => $_GET,
            'post'     => Request::except(array_keys($_GET)),
        ]);
    }

}
