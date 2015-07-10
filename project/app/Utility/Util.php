<?php namespace App\Utility;


use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class  Util
{


    public static function extractParams($params, $prefix = null)
    {
        $columns = [];

        $length = strlen($prefix);
        foreach (explode(',', $params) as $field) {

            if (!$prefix) {
                $columns[] = $field;
                continue;
            }

            if (strpos($field, $prefix) === 0) {
                $columns[] = substr($field, $length);
            }
        }

        return $columns;
    }


    public static function unifyPhoneNumber($phoneNumber, $defaultCountry)
    {
        $phoneUtil = PhoneNumberUtil::getInstance();

        try {
            $phoneProto = $phoneUtil->parse($phoneNumber, $defaultCountry);
            $code = $phoneUtil->getRegionCodeForNumber($phoneProto);
            $number = $phoneUtil->format($phoneProto, PhoneNumberFormat::E164);
        } catch (\libphonenumber\NumberParseException $e) {
            return (object)['number' => $phoneNumber, 'code' => $defaultCountry, 'suspicious' => true];
        }

        return (object)['number' => $number, 'code' => $code, 'suspicious' => false];
    }


    public static function arrayIsValid($array, $requiredFields)
    {
        if(!is_array($requiredFields))
            $requiredFields = explode(',', $requiredFields);

        foreach ($requiredFields as $field) {
            if (!isset($array[$field])) {
                return false;
            }
        }
        return true;
    }

}