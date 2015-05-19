<?php namespace App\Utility\Authenticators;

abstract class Authenticator {

    protected $userId = null;
    protected $userRoles = null;

    public abstract function validate();

    public function getUserId()
    {
        return $this->userId;
    }
}