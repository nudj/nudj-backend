<?php namespace App\Http\Controllers;

use App\Utility\Facades\Shield;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;

use Davibennun\LaravelPushNotification\PushNotification;

use Services_Twilio;

use Log;

class NSX300Controller extends ApiController
{
    public function sendHelloWorldNotificationToSelf()
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

