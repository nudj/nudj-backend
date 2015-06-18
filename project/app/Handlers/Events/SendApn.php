<?php namespace App\Handlers\Events;


use App\Events\LoginUserEvent;
use App\Models\User;
use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Illuminate\Contracts\Queue\ShouldBeQueued;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Mail;

class SendApn implements ShouldBeQueued
{

    public function handle(LoginUserEvent $event)
    {

        $devices = User::min()->find($event->recipientId)->devices()->get();

        foreach($devices as $device) {

            $notifier = new PushNotification();
            $notifier->app('NudgeIOS')
                ->to($device->token)
                ->send($event->message);

        }
    }

}
