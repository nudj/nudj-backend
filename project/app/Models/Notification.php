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
    public static $NUDGE = 7;

    public static $APP_APPLICATION = 2;
    public static $WEB_APPLICATION = 3;
    public static $APP_APPLICATION_NOREF = 5;
    public static $WEB_APPLICATION_NOREF = 6;

    public static $MATCHING_CONTACT = 4;
}


class Notification extends ApiModel
{

    protected $table = 'notifications';
    protected $visible = ['id', 'type_id', 'meta', 'read', 'sender_id', 'created_at'];

    protected $gettableFields = ['type', 'message', 'meta', 'read', 'created', 'sender',];
    protected $defaultFields = ['type', 'message', 'meta', 'read', 'created', 'sender'];

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

	public static function updateNotificationMeta($notificationId, $meta) {

		$notification = Notification::findOrFail($notificationId);
		$oldMeta = json_decode($notification->meta);
		$notification->meta = json_encode(array_merge($oldMeta, $meta));
//		die('here3');

		return $notification->save();
	}

    /* Create different Notification types
    ----------------------------------------------------- */


    public static function askToRefer($recipientId, $senderId, $meta = null)
    {
        if (!Util::arrayIsValid($meta, 'job_id,job_title,job_bonus,message,employer'))
            throw new ApiException(ApiExceptionType::$MISSING_PROPERTY);

        return Notification::add($recipientId, $senderId, NotificationType::$ASK_TO_REFER, $meta);
    }

    public static function appApllication($recipientId, $senderId, $meta = null, $referrer = null)
    {
        if (!Util::arrayIsValid($meta, 'job_id,job_title,position'))
            throw new ApiException(ApiExceptionType::$MISSING_PROPERTY);

        $type = NotificationType::$APP_APPLICATION_NOREF;
        if ($referrer) {
            $type = NotificationType::$APP_APPLICATION;
            $meta['referrer_id'] = $referrer->id;
            $meta['referrer'] = $referrer->name;
        }

        return Notification::add($recipientId, $senderId, $type, $meta);
    }

    public static function webApllication($recipientId, $senderId, $meta = null, $referrer = null)
    {
        if (!Util::arrayIsValid($meta, 'job_id,job_title,position'))
            throw new ApiException(ApiExceptionType::$MISSING_PROPERTY);


        $type = NotificationType::$WEB_APPLICATION_NOREF;
        if ($referrer) {
            $type = NotificationType::$WEB_APPLICATION;
            $meta['referrer_id'] = $referrer->id;
            $meta['referrer'] = $referrer->name;
        }


        return Notification::add($recipientId, $senderId, $type, $meta);
    }

    public static function matchingContact($recipientId, $senderId, $meta = null)
    {
        if (!Util::arrayIsValid($meta, 'candidate, job, employer'))
            throw new ApiException(ApiExceptionType::$MISSING_PROPERTY);

        return Notification::add($recipientId, $senderId, NotificationType::$MATCHING_CONTACT, $meta);
    }


}
