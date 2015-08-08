<?php


namespace App\Utility;


class Snafu {

    public static function show($data, $type = null, $always = false)
    {
        if(!$always && !isset($_GET['debug']))
            return false;

        if(!$always && $type  && $type != $_GET['debug'])
            return false;

        var_dump($data);

        return true;
    }
}