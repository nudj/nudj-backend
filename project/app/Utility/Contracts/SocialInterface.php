<?php namespace App\Utility\Contracts;


interface SocialInterface {

    public function __construct($token);

    public function getUser();

}