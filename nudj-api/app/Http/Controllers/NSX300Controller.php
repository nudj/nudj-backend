<?php namespace App\Http\Controllers;

use App\Utility\Facades\Shield;
use App\Models\User;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Config;

use Services_Twilio;

use Log;

class NSX300Controller extends ApiController
{
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

