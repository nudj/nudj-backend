<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Services_Twilio;

class ConfigController extends ApiController {


	public function index()
	{

		$client = new Services_Twilio(Config::get('cfg.twilio_sid'), Config::get('cfg.twilio_token'));

		$client->account->messages->create(array(
			'To' => "+359 88 467 6575",
			'From' => "+44 20 3322 3966",
			'Body' => "testing message",
			'MediaUrl' => "http://goo.gl",
		));

		return $this->returnResponse(['data' => Config::get('public')]);
	}


	public function show($key = '')
	{
		return $this->returnResponse(['data' => Config::get('public.' . $key)]);
	}

}
