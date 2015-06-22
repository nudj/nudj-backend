<?php namespace App\Handlers\Events;


use App\Events\LoginUserEvent;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use Illuminate\Support\Facades\Config;
use Services_Twilio;

class SendSms implements ShouldBeQueued
{


    public function handle(LoginUserEvent $event)
    {

        $client = new Services_Twilio(Config::get('cfg.twilio_sid'), Config::get('cfg.twilio_token'));

        $client->account->messages->create(array(
            'To' => $event->userPhone,
            'From' => Config::get('cfg.twilio_number'),
            'Body' => $event->verificationCode,
        ));

    }

}
