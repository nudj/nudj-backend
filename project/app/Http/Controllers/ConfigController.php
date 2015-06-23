<?php namespace App\Http\Controllers;


use App\Models\User;
use App\Utility\ApiException;
use App\Utility\ApiExceptionType;
use Davibennun\LaravelPushNotification\Facades\PushNotification;
use Illuminate\Support\Facades\Config;

class ConfigController extends ApiController {


	public function index()
	{

		$user = User::min()->find(6);

		if (!$user)
			throw new ApiException(ApiExceptionType::$USER_MISSING);

		$devices = $user->devices()->get();

		print_r($devices);
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
