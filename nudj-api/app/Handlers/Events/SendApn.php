<?php namespace App\Handlers\Events;

use App\Events\NotifyUserEvent;
use App\Models\Notification;
use App\Models\User;
use App\Utility\Snafu;

use Sly\NotificationPusher\PushManager,
    Sly\NotificationPusher\Adapter\Apns as ApnsAdapter,
    Sly\NotificationPusher\Collection\DeviceCollection,
    Sly\NotificationPusher\Model\Device,
    Sly\NotificationPusher\Model\Message,
    Sly\NotificationPusher\Model\Push
;

use Log;

class SendApn
{

    public function handle(NotifyUserEvent $event)
    {

        // ------------------------------------------------
        // Instanciating a PushManager

        $pushManager = new PushManager(PushManager::ENVIRONMENT_DEV);

        // ------------------------------------------------
        // Building the DeviceCollection

        $devices = User::min()->find($event->recipientId)->devices()->get();
        $arrayOfDs = array();
        foreach($devices as $device){
            $arrayOfDs[] = new Device($device->token);
        }
        $devices = new DeviceCollection($arrayOfDs);


        // ------------------------------------------------
        // Setting up the APNS Adapter

        $apnsAdapter = new ApnsAdapter(array(
            'certificate' => base_path('resources/certificates/production.pem'),
            'passPhrase' => 'turned4437.handwritings'
        ));

        // ------------------------------------------------
        // Making the Notification Options

        $notification_options = array();
        $notification_options['badge'] = Notification::getNewNotificationsCount($event->recipientId);
        $notification_options['sound'] = 'default';
        if($event->meta) {
            $notification_options['custom'] = ['meta' => $event->meta];
        }

        // ------------------------------------------------
        // Building the message objects

        $message = new Message($event->message, $notification_options);

        // ------------------------------------------------
        // Pushing

        $push = new Push($apnsAdapter, $devices, $message);
        $pushManager->add($push);
        $collectionx = $pushManager->push();
        // Log::info(serialize($collectionx));

    }

}
