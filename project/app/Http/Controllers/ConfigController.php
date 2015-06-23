<?php namespace App\Http\Controllers;


use App\Models\Notification;
use Illuminate\Support\Facades\Config;

class ConfigController extends ApiController {


	public function index()
	{
		$res = Notification::add(6, 1, 1);

		return $this->returnResponse(['data' => Config::get('public')]);
	}


	public function show($key = '')
	{
		return $this->returnResponse(['data' => Config::get('public.' . $key)]);
	}

}
