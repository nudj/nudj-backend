<?php namespace App\Handlers\Events;


use App\Events\NotifyUserEvent;
use App\Models\User;
use Davibennun\LaravelPushNotification\PushNotification;
use Illuminate\Contracts\Queue\ShouldBeQueued;


class SendApn implements ShouldBeQueued
{

    public function handle(NotifyUserEvent $event)
    {

        $devices = User::min()->find($event->recipientId)->devices()->get();

        foreach($devices as $device) {

            $notifier = new PushNotification();
            $notifier->app('NudgeIOS')
                ->to($device->token)
                ->send($event->message, $this->meta);

        }
    }

}
