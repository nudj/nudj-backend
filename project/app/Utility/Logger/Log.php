<?php namespace App\Utility\Logger;

use Jenssegers\Mongodb\Model as Moloquent;

class Log extends Moloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'logger';

}
