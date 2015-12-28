<?php namespace App\Handlers\Events;

use App\Events\NotifyUserEvent;
use App\Models\Notification;
use App\Models\User;
use App\Utility\Snafu;
use Davibennun\LaravelPushNotification\PushNotification;
use Illuminate\Contracts\Queue\ShouldBeQueued;

class SendApn implements ShouldBeQueued
{

    public function handle(NotifyUserEvent $event)
    {

        $devices = User::min()->find($event->recipientId)->devices()->get();
        /*

            NOTE: Was wondering where what appears to be this "min" static function was defined

            It's a conjuction of few things
                1. The inheritance chain from Users is Users <- ApiModel <- Model
                2. None of them implements "min"
                3. Actually Model has a __call function which in this case (method name is not 'increment' or 'decrement') forwards the call to an instance of Builder.
                    see: http://php.net/manual/en/language.oop5.magic.php
                4. Builder implements __call and in this instance [*] calls scopeMin which is defined in ApiModel.

                [*] the method name starts with "scope"
                    see: http://laravel.com/docs/5.1/eloquent#query-scopes

            NOTE: User::min() and similar expression for childrens of ApiModel
                simply selects by the primary key.

        */
        $notificationCount = Notification::getNewNotificationsCount($event->recipientId);

        $options['badge'] = $notificationCount;
        if($event->meta) {
            $options['custom'] = ['meta' => $event->meta];
        }

        foreach($devices as $device) {

            $notifier = new PushNotification();
            $notifier->app('NudgeIOS')
                ->to($device->token)
                ->send($event->message, $options);

        }
    }

}
