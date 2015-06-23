<?php namespace App\Handlers\Events;


use App\Events\LoginUserEvent;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use Illuminate\Support\Facades\Config;
use League\Flysystem\Exception;
use Services_Twilio;

class SendSms implements ShouldBeQueued
{


    public function handle(LoginUserEvent $event)
    {
        //mute sms messages while in development
        return true;

        try {
            $client = new Services_Twilio(Config::get('cfg.twilio_sid'), Config::get('cfg.twilio_token'));

            $client->account->messages->create(array(
                'To' => $event->userPhone,
                'From' => Config::get('cfg.twilio_number'),
                'Body' => $event->verificationCode,
            ));
        } catch (Exception $e) {
            throw new ApiException(ApiExceptionType::$TWILIO_ERROR);
        }

    }

}
