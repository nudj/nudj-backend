<?php namespace App\Models;


class Device extends ApiModel
{
    public $timestamps = false;

    protected $table = 'devices';

    /* Relations
    ----------------------------------------------------- */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }


    /* CRUD
    ----------------------------------------------------- */

    public static function add($userId, $input)
    {

        $device = new Device;
        $device->user_id = $userId;
        $device->token = (string) $input['token'];

        $device->save();

        return $device;
    }

}
