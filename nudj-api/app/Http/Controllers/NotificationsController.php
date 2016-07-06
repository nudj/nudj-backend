<?php namespace App\Http\Controllers;

use App\Models\Notification;
use App\Models\User;
use App\Http\Requests;
use App\Utility\Facades\Shield;
use App\Utility\Transformers\NotificationTransformer;

use Sly\NotificationPusher\PushManager,
    Sly\NotificationPusher\Adapter\Apns as ApnsAdapter,
    Sly\NotificationPusher\Collection\DeviceCollection,
    Sly\NotificationPusher\Model\Device,
    Sly\NotificationPusher\Model\Message,
    Sly\NotificationPusher\Model\Push
;

use Log;

class NotificationsController extends ApiController
{

    public function index()
    {
        $id = Shield::getUserId();
        $items = User::min()->find($id)->notifications()->api()->desc()->paginate($this->limit);
        return $this->respondWithPagination($items, new NotificationTransformer());
    }

    public function read($id)
    {
        return $this->respondWithStatus(Notification::markRead($id));
    }

    public function test()
    {

        // Following the instructions at https://github.com/Ph3nol/NotificationPusher/blob/master/doc/getting-started.md

        // ------------------------------------------------
        // Instanciating a PushManager

        $pushManager = new PushManager(PushManager::ENVIRONMENT_DEV);

        Log::info('Instanciating a PushManager (2)');

        $id = Shield::getUserId();
        $me = User::api()->findOrFail($id);

        // ------------------------------------------------
        // Building the DeviceCollection

        Log::info('Building the DeviceCollection (2)');

        $devices = $me->devices()->get();
        $arrayOfDs = array();
        foreach($devices as $device){
            $arrayOfDs[] = new Device($device->token);
        }
        $devices = new DeviceCollection($arrayOfDs);

        // ------------------------------------------------
        // Setting up the APNS Adapter

        Log::info('Setting up the APNS Adapter (2)');

        $apnsAdapter = new ApnsAdapter(array(
            'certificate' => base_path('resources/certificates/production.pem'),
            'passPhrase' => 'turned4437.handwritings'
        ));

        // ------------------------------------------------
        // Making the Notification Options

        Log::info('Making the Notification Options (2)');

        $notification_options = array(
            'badge' => 1,
            'sound' => 'default'
        );

        // ------------------------------------------------
        // Building the message object

        Log::info('Building the message objects (2)');

        $message = new Message('This is a test notification from Nudj', array(
            'badge' => 1,
            'sound' => 'default'
        ));

        // ------------------------------------------------
        // Pushing

        Log::info('Pushing notification to Apple (2)');

        $push = new Push($apnsAdapter, $devices, $message);
        $pushManager->add($push);
        $pushManager->push();

        return $this->returnResponse(['data' => true]); 

    }

}
