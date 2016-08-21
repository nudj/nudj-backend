<?php namespace App\Http\Requests;

use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use Illuminate\Foundation\Http\FormRequest;

abstract class ApiRequest extends FormRequest {

    public function response(array $errors)
    {
        throw new ApiException(ApiExceptionType::$VALIDATION_ERROR, $errors);
    }

    public function forbiddenResponse()
    {
        throw new ApiException(ApiExceptionType::$UNAUTHORIZED);
    }

}