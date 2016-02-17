<?php namespace App\Http\Controllers;

use App\Utility\Facades\Shield;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;

use Davibennun\LaravelPushNotification\PushNotification;

use Sly\NotificationPusher\PushManager,
    Sly\NotificationPusher\Adapter\Apns as ApnsAdapter,
    Sly\NotificationPusher\Collection\DeviceCollection,
    Sly\NotificationPusher\Model\Device,
    Sly\NotificationPusher\Model\Message,
    Sly\NotificationPusher\Model\Push
;

use Services_Twilio;

use Log;

class NSX300Controller extends ApiController
{
    public function sendHelloWorldNotificationToSelf_version1()
    {
        $id = Shield::getUserId();
        $me = User::api()->findOrFail($id);
        $devices = $me->devices()->get();

        foreach($devices as $device){
            $options['badge'] = 1;
            $notifier = new PushNotification();
            $notifier->app([
                    'environment' => 'production',
                    'certificate' => base_path('resources/certificates/production.pem'),
                    'passPhrase'  => 'turned4437.handwritings',
                    'service'     => 'apns'
                ])
                ->to($device->token)
                ->send("Hello world", $options);
        }

        return $this->returnResponse(['data' => true]); 

    }

    public function sendHelloWorldNotificationToSelf_version2()
    {

        Log::info('sendHelloWorldNotificationToSelf_version2()');

        // following the instructions at https://github.com/Ph3nol/NotificationPusher/blob/master/doc/getting-started.md

        // First, instantiate the manager and declare an adapter.
        $pushManager = new PushManager(PushManager::ENVIRONMENT_DEV);


        $apnsAdapter = new ApnsAdapter(array(
            'certificate' => base_path('resources/certificates/production.pem'),
            'passPhrase' => 'turned4437.handwritings'
        ));

        // Set the device(s) to push the notification to.
        $devices = new DeviceCollection(array(
            new Device('75bc705799589b7ad3c20aa05027d58e1438c989bfd6b51125180b81075384f8')
        ));

        $message = new Message('Hello world from Pascal', array(
            'badge' => 1,
            'sound' => 'example.aiff',
            // ...
        ));

        // Finally, create and add the push to the manager, and push it!
        $push = new Push($apnsAdapter, $devices, $message);
        $pushManager->add($push);
        $pushManager->push();

        return $this->returnResponse(['data' => true]); 

    }

    public function sendSMSNotificationToNumber($number)
    {
        $id = Shield::getUserId();
        Log::info($number);

        try {
            $client = new Services_Twilio(Config::get('cfg.twilio_sid'), Config::get('cfg.twilio_token'));
            $client->account->messages->create(array(
                'To'   => $number,
                'From' => '+44 20 3322 3966',
                'Body' => 'Hello World',
            ));
        } catch (Exception $e) {
            throw new ApiException(ApiExceptionType::$TWILIO_ERROR);
        }

        return $this->returnResponse(['data' => true]); 

    }

}

