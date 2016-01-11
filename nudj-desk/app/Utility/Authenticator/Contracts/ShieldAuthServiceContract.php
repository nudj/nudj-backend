<?php namespace App\Utility\Authenticator\Contracts;

interface ShieldAuthServiceContract {

    public function findByToken($token = null);

}