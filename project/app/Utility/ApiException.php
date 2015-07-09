<?php namespace App\Utility;

use Illuminate\Support\Facades\Lang;


class ApiException extends \Exception
{

    private $errorCode = null;
    private $errorInfo = null;
    private $notify = null;

    public function __construct($type = null, $errors = null, $notify = null)
    {

        $this->notify = ($notify !== null) ? $notify : $type['notify'];
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

    public  function shouldNotify() {
        return (bool) $this->notify;
    }


}