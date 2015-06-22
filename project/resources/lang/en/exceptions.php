<?php

use App\Utility\ApiExceptionType;

return [

    // General Errors
    ApiExceptionType::$GENERAL_ERROR['errorCode'] => "General Error :: Something is wrong but we don't know what",

    ApiExceptionType::$BAD_REQUEST['errorCode'] => "Bad Request",
    ApiExceptionType::$UNAUTHORIZED['errorCode'] => "Unauthorized",
    ApiExceptionType::$NOT_FOUND['errorCode'] => "Not Found",

    // Development Errors
    ApiExceptionType::$MISSING_PROPERTY['errorCode'] => "Development Error :: Missing Property",

    // API Errors
    ApiExceptionType::$NO_TOKEN['errorCode'] => "No valid token supplied",
    ApiExceptionType::$VALIDATION_ERROR['errorCode'] => "Validation Error :: One or more fields does not meet the requirements",
    ApiExceptionType::$INVALID_INPUT['errorCode'] => "Invalid Input",

    // File Errors
    ApiExceptionType::$IMAGE_ERROR['errorCode'] => "Image Error",
    ApiExceptionType::$RACKSPACE_ERROR['errorCode'] => "Rackspace Error",

    // Third Party Errors
    ApiExceptionType::$TWILIO_ERROR['errorCode'] => "Twilio Error",

    // Nudge Errors
    ApiExceptionType::$VERIFICATION_ERROR['errorCode'] => "Wrong Verification Code",
    ApiExceptionType::$USER_MISSING['errorCode'] => "User not found in our database",

];
