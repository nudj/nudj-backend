<?php


namespace app\Utility;


class Snafu {

    public static  function show($data, $type = null)
    {
        if(!isset($_GET['debug']))
            return false;

        if($type  && $type != $_GET['debug'])
            return false;

        var_dump($data);

        return true;
    }
}