<?php namespace App\Utility\Authenticators;

use App\Utility\Contracts\ApiAuthenticable;
use App\Utility\Contracts\ApiUserRepositoryInterface;
use League\Flysystem\Exception;

abstract class Authenticator implements ApiAuthenticable{

    /*
     * User Repository used for authentication
     *
     * @var ApiUserRepositoryInterface
     */
    protected $user;

    /*
     * TheUser's id in the system
     *
     * @property int $userId
     */
    protected $userId;

    /*
     * A list of user roles
     *
     * @property array $userRoles
     */
    protected $userRoles;


    public function __construct($user)
    {

        if (!($user instanceof ApiUserRepositoryInterface))
            throw new \InvalidArgumentException ();

        $this->user = $user;
    }

    public abstract function validate();

    public function hasRole($role)
    {
        if(!$this->userRoles)
            return false;

        return (bool) in_array($role, $this->userRoles);
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function returnUser()
    {
        return $this->user->find($this->userId);
    }





}