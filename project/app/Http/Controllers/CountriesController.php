<?php namespace App\Http\Controllers;

use App\Models\Country;

class CountriesController extends ApiController {

	public function index()
	{
		return response()->json(Country::web()->orderBy('name', 'asc')->get());
	}

}
