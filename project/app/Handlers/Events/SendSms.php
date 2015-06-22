<?php namespace App\Handlers\Events;


use App\Events\LoginUserEvent;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;
use Services_Twilio;

class SendSms implements ShouldBeQueued
{



    public function handle(LoginUserEvent $event)
    {

        $client = new Services_Twilio(Config::get('cfg.twilio_sid'), Config::get('cfg.twilio_token'));

        $client->account->messages->create(array(
            'To' => "+359 88 467 6575",
            'From' => "+359 88 467 6575",
            'Body' => "testing message",
            'MediaUrl' => "http://goo.gl",
        ));

//        Mail::send('emails.errors.exception', array('error' => $event->verificationCode), function ($message) {
//            $message->from(Config::get('cfg.email_system'));
//            $message->to(Config::get('cfg.email_notifications'));
//            $message->subject('SMS');
//        });

    }

}
