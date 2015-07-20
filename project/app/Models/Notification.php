<?php namespace App\Models;

use App\Events\NotifyUserEvent;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use App\Utility\Transformers\NotificationTransformer;
use App\Utility\Util;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Lang;


class NotificationType
{

    public static $ASK_TO_REFER = 1;
    public static $APP_APPLICATION = 2;
    public static $WEB_APPLICATION = 3;
    public static $MATCHING_CONTACT = 4;

}


class Notification extends ApiModel
{

    protected $table = 'notifications';
    protected $visible = ['id', 'type_id', 'meta', 'read', 'sender_id'];

    protected $gettableFields = ['type', 'message', 'read', 'sender', 'meta'];
    protected $defaultFields = ['type', 'message', 'meta', 'read'];

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

        Event::fire(new NotifyUserEvent($recipientId, $notification->getMessage($meta)));

        return $notification;
    }

    public function getMessage($meta = [])
    {
        return Lang::get('notifications.' . $this->type_id, $meta);
    }


    /* Actions
   ----------------------------------------------------- */

    public static function markRead($id)
    {

        $notification = self::find($id);

        if (!$notification)
            return false;

        $notification->read = true;
        $notification->save();

        return true;
    }

    /* Create different Notification types
    ----------------------------------------------------- */


    public static function createAskToReferNotification($recipientId, $senderId, $meta = null)
    {
        if(!Util::arrayIsValid($meta, 'message,employer'))
            throw new ApiException(ApiExceptionType::$MISSING_PROPERTY);

        return Notification::add($recipientId, $senderId, NotificationType::$ASK_TO_REFER, $meta);
    }

    public static function createNewApplicationNotification($recipientId, $senderId, $meta = null)
    {
        if(!Util::arrayIsValid($meta, 'candidate, referrer, position'))
            throw new ApiException(ApiExceptionType::$MISSING_PROPERTY);

        return Notification::add($recipientId, $senderId, NotificationType::$NEW_APPLICATION, $meta);
    }

    public static function createMatchingContactNotification($recipientId, $senderId, $meta = null)
    {
        if(!Util::arrayIsValid($meta, 'candidate, job, employer'))
            throw new ApiException(ApiExceptionType::$MISSING_PROPERTY);

        return Notification::add($recipientId, $senderId, NotificationType::$MATCHING_CONTACT, $meta);
    }



}
