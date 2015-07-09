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
        $device = Device::where('token', '=', $input['token'])->first();

        if ($device && $device->user_id == $userId) {
            return $device;
        } elseif ($device && $device->user_id != $userId) {
            $device->delete();
        }

        $device = new Device;
        $device->user_id = $userId;
        $device->token = (string)$input['token'];
        $device->save();

        return $device;

    }

}
