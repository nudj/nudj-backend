<?php namespace App\Exceptions;

use App\Exceptions\Input;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{

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
     * @param  \Exception $e
     * @return void
     */
    public function report(Exception $e)
    {
        return parent::report($e);
    }

    private function respond($response, $code, $notify = false)
    {

        if (Config::get('cfg.request_timestamp'))
            $response['timestamp'] = Request::server('REQUEST_TIME_FLOAT');

        if ($notify) {
            Mail::send('emails.errors.exception', array('error' => $response), function ($message) {
                $message->from(Config::get('cfg.email_system'));
                $message->to(Config::get('cfg.email_notifications'));
                $message->subject('New Exception!');
            });
        }

        return response($response, $code);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {

        // handle all exceptions thrown by the API
        if ($e instanceof ApiException) {

            $response['error'] = [
                'message' => $e->getMessage(),
                'code' => $e->getErrorCode()
            ];

            if ($e->getErrorInfo())
                $response['error']['message'] = $response['error']['message'] . ' :: ' . $e->getErrorInfo();

            return $this->respond($response, $e->getCode(), $e->shouldNotify());
        }

        // throw api exception for wrong endpoints
        if ($e instanceof NotFoundHttpException ) {
            throw new ApiException(ApiExceptionType::$INVALID_ENDPOINT);
        }

        // map framework exceptions to ApiException
        if ($e instanceof ModelNotFoundException) {

            $modelName = explode('\\', $e->getModel());
            $resourceMissing = strtoupper(array_pop($modelName) . '_MISSING');

            if(property_exists(new ApiExceptionType(), $resourceMissing))
                throw new ApiException(ApiExceptionType::$$resourceMissing);
            else
                throw new ApiException(ApiExceptionType::$GENERAL_ERROR, $e->getMessage());
        }

        // Handles all other exceptions

        if ( env('APP_ENV')!='production' ) {
            $response['error'] = [
                'message' => $e->getMessage(),
                'code' => 10001
            ];
            return $this->respond($response, 400);
        }

        return parent::render($request, $e);
    }

}
