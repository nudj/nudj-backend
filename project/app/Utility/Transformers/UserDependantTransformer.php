<?php namespace App\Utility\Transformers;


abstract class UserDependantTransformer extends Transformer
{

    protected $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

}