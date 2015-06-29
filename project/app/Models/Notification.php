<?php namespace App\Models;

use App\Events\NotifyUserEvent;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Transformers\NotificationTransformer;
use Davibennun\LaravelPushNotification\PushNotification;
use Illuminate\Support\Facades\Event;


class NotificationType
{

    public static $ASK_TO_REFER = 1;
    public static $RECEIVE_NUDGE = 2;
    public static $MATCHING_CONTACT = 3;

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

        $recipient = User::find($recipientId);

        if (!$recipient)
            throw new ApiException(ApiExceptionType::$USER_MISSING);

        if (!$recipient->isNotificationAllowed($typeId))
            return false;


        $notification = new Notification;

        $notification->recipient_id = (int)$recipientId;
        $notification->sender_id = (int)$senderId;
        $notification->type_id = (int)$typeId;
        $notification->meta = json_encode($meta);
        $notification->read = false;

        $notification->save();


        Event::fire(new NotifyUserEvent($recipientId, $notification->getMessage()));

        return $notification;
    }

    public function getMessage()
    {
        switch ($this->type_id) {
            case NotificationType::$RECEIVE_NUDGE :
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


}
