<?php

namespace App\Models\Traits;


trait Hashable {

    public static function findByHash($hash = null, $field = 'hash')
    {
        return self::where($field, '=', (string) $hash)->first();
    }

    public static function generateUniqueHash($field = 'hash', $length = 10)
    {
        $hash = str_random($length);
        while (self::where($field, '=', $hash)->count()) {
            $hash = self::generateUniqueHash();
        }

        return $hash;
    }

}