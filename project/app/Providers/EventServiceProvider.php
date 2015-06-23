<?php namespace App\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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
		'App\Events\LoginUserEvent' => [
			'App\Handlers\Events\SendSms',
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

		//
	}

}
