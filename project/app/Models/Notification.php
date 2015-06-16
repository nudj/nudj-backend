<?php namespace App\Models;

use App\Utility\Transformers\NotificationTransformer;

class Notification extends ApiModel {

    protected $table = 'notifications';
    protected $visible = ['type_id', 'meta', 'read'];

    protected $gettableFields = ['type', 'message', 'read'];
    protected $defaultFields = ['type', 'message', 'read'];

    protected $prefix = 'notify.';

    public function __construct() {
        $this->dependencies = NotificationTransformer::$dependencies;
    }

    /* Relations
    ----------------------------------------------------- */
    public function recipient()
    {
        return $this->belongsTo('App\Models\User', 'recipient_id');
    }

    public function sender()
    {
        return $this->belongsTo('App\Models\User', 'sender_id');
    }


    /* CRUD
    ----------------------------------------------------- */

    public static function add($recepientId, $senderId, $typeId, $meta = null)
    {

        $notification = new Notification;

        $notification->recepient_id = (int) $recepientId;
        $notification->sender_id = (int) $senderId;
        $notification->type_id = (int) $typeId;
        $notification->meta = json_encode($meta);

        $notification->read = false;

        $notification->save();

        return $notification;
    }

}
