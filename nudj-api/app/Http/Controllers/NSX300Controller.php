<?php namespace App\Http\Controllers;

use App\Utility\Facades\Shield;
use App\Models\User;
use Davibennun\LaravelPushNotification\PushNotification;
use Illuminate\Support\Facades\Input;

use Log;

class NSX300Controller extends ApiController
{
    public function send_hello_world_notification_to_self()
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
}

