<?php namespace App\Http\Controllers;


use App\Models\User;
use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Illuminate\Support\Facades\Config;

class ConfigController extends ApiController {


	public function index()
	{


		$recipientId = 6;
		$devices = User::min()->find($recipientId)->devices()->get();

		foreach ($devices as $device) {

			$notifier = new PushNotification();
			$notifier->app('NudgeIOS')
				->to($device->token)
				->send('Hi Ant');

		}
		die('sent');

		return $this->returnResponse(['data' => Config::get('public')]);
	}


	public function show($key = '')
	{
		return $this->returnResponse(['data' => Config::get('public.' . $key)]);
	}

}
