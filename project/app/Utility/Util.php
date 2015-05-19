<?php namespace App\Utility;


class Util {


    public static function extractParams($params, $prefix = null)
    {
        $columns = [];

        $length = strlen($prefix);
        foreach (explode(',', $params) as $field) {

            if(!$prefix) {
                $columns[] = $field;
                continue;
            }

            if (strpos($field, $prefix) === 0) {
                $columns[] = substr($field, $length);
            }
        }

        return $columns;
    }



}