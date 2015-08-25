<?php namespace App\Http\Controllers;


use App\Models\Country;
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


	public function countries()
	{
		return $this->returnResponse(Country::web()->orderBy('name', 'asc')->get());
	}

}
