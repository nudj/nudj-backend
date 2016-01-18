<?php namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

use Log;

class EventServiceProvider extends ServiceProvider {

	/**
	 * The event handler mappings for the application.
	 *
	 * @var array
	 */
	protected $listen = [
		'App\Events\IncomingRequestEvent' => [
			'App\Handlers\Events\LogRequest',
		],
		'App\Events\ReturnResponseEvent' => [
			'App\Handlers\Events\LogResponse',
		],
		'App\Events\NotifyUserEvent' => [
			'App\Handlers\Events\SendApn',
		],
		'App\Events\StartChatEvent' => [
			'App\Handlers\Events\StartChat',
		],
	];

	/**
	 * Register any other events for your application.
	 *
	 * @param  \Illuminate\Contracts\Events\Dispatcher  $events
	 * @return void
	 */
	public function boot(DispatcherContract $events)
	{
		parent::boot($events);
		Event::subscribe('App\Handlers\Events\SendSms');
	}

}
