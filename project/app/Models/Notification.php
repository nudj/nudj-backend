<?php namespace App\Models;

use App\Utility\Transformers\NotificationTransformer;
use Davibennun\LaravelPushNotification\PushNotification;


class NotificationType
{

    public static $NUDGE = 1;

}


class Notification extends ApiModel
{

    protected $table = 'notifications';
    protected $visible = ['id', 'type_id', 'meta', 'read'];

    protected $gettableFields = ['type', 'message', 'read'];
    protected $defaultFields = ['type', 'message', 'read'];

    protected $prefix = 'notify.';

    public function __construct()
    {
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

    public static function add($recipientId, $senderId, $typeId, $meta = null)
    {

        Notification::sendApnNotifications($recipientId);
        die();

        $notification = new Notification;

        $notification->recipient_id = (int)$recipientId;
        $notification->sender_id = (int)$senderId;
        $notification->type_id = (int)$typeId;
        $notification->meta = json_encode($meta);

        $notification->read = false;

        $notification->save();

        Notification::sendApnNotifications($notification->recipient_id);

        return $notification;
    }

    public function getMessage()
    {
        switch ($this->type_id) {
            case NotificationType::$NUDGE :
                return 'Somebody nudged you';
                break;
            default :
                return null;

        }

    }


    /* Create different Notification types
    ----------------------------------------------------- */

    public static function addNudge($recipientId, $senderId, $meta = null)
    {
        return Notification::add($recipientId, $senderId, NotificationType::$NUDGE, $meta);
    }


    /* APN
    ----------------------------------------------------- */

    private static function sendApnNotifications($recipientId, $message = '')
    {

        $devices = User::min()->find($recipientId)->devices()->get();

       foreach($devices as $device) {

           $notifier = new PushNotification();
           $notifier->app('NudgeIOS')
               ->to($device->token)
               ->send($message);

       }

        return true;

    }
}
