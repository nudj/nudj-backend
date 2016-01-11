<?php namespace App\Utility\Logger;

use Jenssegers\Mongodb\Model as Moloquent;

class Log extends Moloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'requests';

    protected $fillable = ['id', 'type', 'from', 'endpoint', 'token', 'get', 'post', 'response'];

    public function display()
    {
        $response = [];
        foreach ($this->fillable as $field)
            $response[$field] = $this->{$field};

        return json_encode($response);
    }

}
