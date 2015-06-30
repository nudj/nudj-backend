<?php namespace App\Utility\Contracts;


interface ApiUserRepositoryInterface {

    public static function find($id);

    public function findByToken($token = null);

}