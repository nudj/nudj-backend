<?php


if (!function_exists('api_url')) {

    function api_url($path = null, $parameters = array(), $secure = null)
    {
        $path = 'api/v1/' . $path;
        return app('Illuminate\Contracts\Routing\UrlGenerator')->to($path, $parameters, $secure);
    }
}


if (!function_exists('admin_url')) {

    function admin_url($path = null, $parameters = array(), $secure = null)
    {
        $path = 'admin/' . $path;
        return app('Illuminate\Contracts\Routing\UrlGenerator')->to($path, $parameters, $secure);
    }
}

