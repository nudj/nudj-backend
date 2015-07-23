<?php namespace App\Utility\Logger;

use Jenssegers\Mongodb\Model as Moloquent;

class Log extends Moloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'requests';

    protected $fillable = ['id', 'type', 'from', 'endpoint', 'token', 'get', 'post'];


    public function display()
    {
        return json_encode([
            'id' => $this->id,
            'token' => $this->token,
        ]);
    }

}
