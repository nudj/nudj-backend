<?php namespace App\Console\Commands;

/*

	This came up when I was working on 
		Route::get('nsx300/app_notification_to_me', 'NSX300Controller@sendHelloWorldNotificationToSelf');
	for Richard, but otherwise not in use.
*/

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Illuminate\Support\Facades\Config;

use Davibennun\LaravelPushNotification\PushNotification;
use App\Models\User;

class PascalSendAppNotification extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'pascal:sendappnotification';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Performs sending of app notification.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{

        $robyn = User::api()->findOrFail(217);
        $devices = $robyn->devices()->get();

        foreach($devices as $device){
            $options['badge'] = 1;
            $notifier = new PushNotification();
            $notifier->app('NudgeIOS')
                ->to($device->token)
                ->send("Hello world", $options);         	
        }

	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return [
			// ['example', InputArgument::REQUIRED, 'An example argument.'],
		];
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return [
			// ['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
		];
	}

}
