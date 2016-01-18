<?php namespace App\Handlers\Events;

use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use Illuminate\Support\Facades\Config;
use League\Flysystem\Exception;
use Services_Twilio;

use Log;

class SendSms implements ShouldBeQueued
{

    public function send($event)
    {
        $availablePhones = config('phones');

        if(!isset($availablePhones[$event->countryCode]))
            throw new ApiException(ApiExceptionType::$TWILIO_ERROR);

        $sendPhone = $availablePhones[$event->countryCode];

        try {
            $client = new Services_Twilio(Config::get('cfg.twilio_sid'), Config::get('cfg.twilio_token'));
            $client->account->messages->create(array(
                'To' => $event->phone,
                'From' => $sendPhone,
                'Body' => $event->message,
            ));
        } catch (Exception $e) {
            throw new ApiException(ApiExceptionType::$TWILIO_ERROR);
        }
    }

    public function subscribe($events)
    {
        $events->listen('App\Events\LoginUserEvent', 'App\Handlers\Events\SendSms@send');
        $events->listen('App\Events\SendMessageToContactEvent', 'App\Handlers\Events\SendSms@send');
    }

}
