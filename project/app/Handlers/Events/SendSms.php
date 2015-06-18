<?php namespace App\Handlers\Events;


use App\Events\LoginUserEvent;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendSms implements ShouldBeQueued
{



    public function handle(LoginUserEvent $event)
    {

        Mail::send('emails.errors.exception', array('error' => $event->verificationCode), function ($message) {
            $message->from(Config::get('cfg.email_system'));
            $message->to(Config::get('cfg.email_notifications'));
            $message->subject('SMS');
        });

    }

}
