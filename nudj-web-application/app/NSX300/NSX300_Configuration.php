<?php

namespace App\NSX300;

class NSX300_Configuration {

    public static function getApplicationURL(){
        if(env('APP_ENV')=='production'){
            return "https://mobileweb.nudj.co";
        }
        if(env('APP_ENV')=='staging'){
            return "https://mobileweb-dev.nudj.co";
        }
        if(env('APP_ENV')=='development'){
            return "http://localhost:8000";
        }
        return 'http://example.com';
    }

}
