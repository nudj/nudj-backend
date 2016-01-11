<?php namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;

class ConfigController extends ApiController {

	public function index()
	{

		return $this->returnResponse(['data' => Config::get('public')]);
	}

	public function show($key = '')
	{
		return $this->returnResponse(['data' => Config::get('public.' . $key)]);
	}

}
