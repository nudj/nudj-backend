<?php

namespace App\Utility;


class ApiExceptionType {

    //General Errors
    public static $GENERAL_ERROR        = ['errorCode' => 10001, 'code' => 400, 'notify' => false];

    //Development Errors
    public static $INVALID_ENDPOINT     = ['errorCode' => 10101, 'code' => 400, 'notify' => false];
    public static $MISSING_PROPERTY     = ['errorCode' => 10102, 'code' => 400, 'notify' => false];

    public static $BAD_REQUEST          = ['errorCode' => 10400, 'code' => 400, 'notify' => false];
    public static $UNAUTHORIZED         = ['errorCode' => 10401, 'code' => 401, 'notify' => false];
    public static $NOT_FOUND            = ['errorCode' => 10404, 'code' => 404, 'notify' => false];

    //API Errors
    public static $NO_TOKEN             = ['errorCode' => 11101, 'code' => 400, 'notify' => false];
    public static $VALIDATION_ERROR     = ['errorCode' => 11102, 'code' => 400, 'notify' => false];
    public static $INVALID_INPUT        = ['errorCode' => 11103, 'code' => 400, 'notify' => false];

    // File Errors
    public static $IMAGE_ERROR          = ['errorCode' => 12101, 'code' => 400, 'notify' => false];
    public static $RACKSPACE_ERROR      = ['errorCode' => 12201, 'code' => 400, 'notify' => false];

    // Third Party Errors
    public static $TWILIO_ERROR         = ['errorCode' => 13101, 'code' => 400, 'notify' => true];
    public static $FACEBOOK_ERROR       = ['errorCode' => 13201, 'code' => 400, 'notify' => false];
    public static $CHAT_ERROR           = ['errorCode' => 13301, 'code' => 400, 'notify' => false];
    public static $LINKEDIN_ERROR       = ['errorCode' => 13401, 'code' => 400, 'notify' => false];
    public static $ELASTIC_ERROR        = ['errorCode' => 13501, 'code' => 400, 'notify' => false];
    public static $ELASTIC_MISSING        = ['errorCode' => 13502, 'code' => 400, 'notify' => false];

    // Nudge Errors
    public static $VERIFICATION_ERROR   = ['errorCode' => 14101, 'code' => 400, 'notify' => false];
    public static $USER_MISSING         = ['errorCode' => 14201, 'code' => 404, 'notify' => false];
    public static $CHAT_MISSING         = ['errorCode' => 14301, 'code' => 404, 'notify' => false];
    public static $JOB_MISSING          = ['errorCode' => 14401, 'code' => 404, 'notify' => false];
    public static $JOB_OWNER_MISMATCH   = ['errorCode' => 14402, 'code' => 400, 'notify' => false];
    public static $CONTACT_MISSING      = ['errorCode' => 14501, 'code' => 404, 'notify' => false];
    public static $REFERRAL_MISSING     = ['errorCode' => 14601, 'code' => 404, 'notify' => false];
    public static $NUDGE_MISSING        = ['errorCode' => 14701, 'code' => 404, 'notify' => false];


}