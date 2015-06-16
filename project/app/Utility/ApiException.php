<?php namespace App\Utility;

use Illuminate\Support\Facades\Lang;

class ApiExceptionType {

    //General Errors
    public static $GENERAL_ERROR    = ['errorCode' => 10000, 'code' => 400];

    public static $BAD_REQUEST      = ['errorCode' => 10400, 'code' => 400];
    public static $UNAUTHORIZED     = ['errorCode' => 10401, 'code' => 401];
    public static $NOT_FOUND        = ['errorCode' => 10404, 'code' => 404];

    //API Errors
    public static $NO_TOKEN         = ['errorCode' => 11101, 'code' => 400];
    public static $VALIDATION_ERROR = ['errorCode' => 11102, 'code' => 400];
    public static $INVALID_INPUT    = ['errorCode' => 11103, 'code' => 400];

    // File Errors
    public static $IMAGE_ERROR      = ['errorCode' => 12100, 'code' => 400];
    public static $RACKSPACE_ERROR  = ['errorCode' => 12200, 'code' => 400];

    // Nudge Errors
    public static $VERIFICATION_ERROR    = ['errorCode' => 13101, 'code' => 400];
}

class ApiException extends \Exception
{

    private $errorCode = null;
    private $errorInfo = null;

    public function __construct($type = null, $errors = null)
    {
        $this->errorCode = $type['errorCode'];
        $this->errorInfo = $errors;

        $message = Lang::get('exceptions.' . $this->errorCode);

        parent::__construct($message, $type['code']);
    }

    public  function getErrorCode() {
        return $this->errorCode;
    }

    public  function getErrorInfo() {
        return $this->errorInfo;
    }


}