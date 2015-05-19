<?php namespace App\Utility;

use Illuminate\Support\Facades\Lang;

class ApiExceptionType {

    public static $GENERAL_ERROR    = ['errorCode' => 10001, 'code' => 400];
    public static $UNAUTHORIZED     = ['errorCode' => 10002, 'code' => 403];
    public static $NOT_FOUND        = ['errorCode' => 10003, 'code' => 404];
    public static $NO_TOKEN         = ['errorCode' => 10004, 'code' => 400];
    public static $VALIDATION_ERROR = ['errorCode' => 10005, 'code' => 400];
    public static $INVALID_INPUT    = ['errorCode' => 10006, 'code' => 400];
}

class ApiException extends \Exception
{

    protected $errorCode = null;
    protected $errorInfo = null;

    public function __construct($type = null, $errors = null)
    {
        $this->errorCode = $type['errorCode'];
        $this->errorInfo = $errors;

        $message = Lang::get('exceptions.' . $this->errorCode);
        $code = ApiExceptionType::$GENERAL_ERROR['code'];

        parent::__construct($message, $code);
    }

    public  function getErrorCode() {
        return $this->errorCode;
    }

    public  function getErrorInfo() {
        return $this->errorInfo;
    }


}