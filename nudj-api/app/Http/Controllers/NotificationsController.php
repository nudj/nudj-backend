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

        // First, instantiate the manager and declare an adapter.

        $pushManager = new PushManager(PushManager::ENVIRONMENT_DEV);

        $id = Shield::getUserId();
        $me = User::api()->findOrFail($id);
        $devices = $me->devices()->get();

        $arrayOfDs = array();
        foreach($devices as $device){
            $arrayOfDs[] = new Device($device->token);
        }

        $apnsAdapter = new ApnsAdapter(array(
            'certificate' => base_path('resources/certificates/production.pem'),
            'passPhrase' => 'turned4437.handwritings'
        ));

        // Set the device(s) to push the notification to.

        $devices = new DeviceCollection($arrayOfDs);

        $message = new Message('This is a test notification from Nudj', array(
            'badge' => 1,
            'sound' => 'default'
        ));

        // Finally, create and add the push to the manager, and push it!
        $push = new Push($apnsAdapter, $devices, $message);
        $pushManager->add($push);
        $collectionx = $pushManager->push();
        Log::info(serialize((array)$collectionx));

        return $this->returnResponse(['data' => true]); 

    }

}
