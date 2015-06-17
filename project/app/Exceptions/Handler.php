<?php namespace App\Exceptions;

use App\Utility\ApiException;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler {

	/**
	 * A list of the exception types that should not be reported.
	 *
	 * @var array
	 */
	protected $dontReport = [
		'Symfony\Component\HttpKernel\Exception\HttpException'
	];

	/**
	 * Report or log an exception.
	 *
	 * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
	 *
	 * @param  \Exception  $e
	 * @return void
	 */
	public function report(Exception $e)
	{
		return parent::report($e);
	}

	/**
	 * Render an exception into an HTTP response.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Exception  $e
	 * @return \Illuminate\Http\Response
	 */
    public function render($request, Exception $e)
    {

        // handle all exceptions thrown by the API
        if ($e instanceof ApiException) {

            if(Config::get('cfg.request_timestamp'))
                $response['timestamp'] = Request::server('REQUEST_TIME_FLOAT');


            $response['error'] = [
                "message" => $e->getMessage(),
                "error_code" => $e->getErrorCode()
            ];

            if($e->getErrorInfo())
                $response['error']['message'] = $response['error']['message'] . ' :: ' . $e->getErrorInfo();

            if($e->shouldNotify()) {
                $sent = Mail::send('emails.errors.exception', array('error' => $response), function($message)
                {
                    $message->from(Config::get('cfg.email_system'));
                    $message->to(Config::get('cfg.email_notifications'));
                    $message->subject('New Exception!');
                });

                var_dump($sent);
            }

            return response($response, $e->getCode());
        }

        // handle all other thrown exception
        if (!env('APP_DEBUG')) {

            $response['error'] = ["message" => "Something went wrong: " . $e->getMessage()];
            $errorCode = $e->getCode() ?: 400;

            return response($response, $errorCode);
        }

        return parent::render($request, $e);
    }

}
