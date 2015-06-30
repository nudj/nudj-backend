<?php namespace App\Utility\Contracts;

interface ApiAuthenticable {


    /*
     * Validates a request
     *
     * @return bool
     */
    public function validate();


    /*
    * Check if a role belongs to a user
    *
    * @param string $role
    * @return bool
    */
    public function hasRole($role);

    /*
    * Returns the unique indetifier of the authenticated user
    *
    * @return int
    */
    public function getUserId();
}