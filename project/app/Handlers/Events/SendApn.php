<?php namespace App\Handlers\Events;


use App\Events\LoginUserEvent;
use App\Models\User;
use Davibennun\LaravelPushNotification\PushNotification;
use Illuminate\Contracts\Queue\ShouldBeQueued;


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
