<?php namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

use Illuminate\Support\Facades\Config;

use Davibennun\LaravelPushNotification\PushNotification;

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

        $options = [];
        $options['badge'] = 2;

        $device_token = 'e130db42fe614feb07899521ffca1d1466f2f7cb1345cbe2f2c566a4c917d2c0';
        $message = 'Hello World';

        $notifier = new PushNotification();
        $notifier->app('NudgeIOS')
            ->to($device_token)
            ->send($message, $options);
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
