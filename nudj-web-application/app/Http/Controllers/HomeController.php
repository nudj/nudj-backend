<?php namespace App\Http\Controllers;

class HomeController extends \Illuminate\Routing\Controller {

	public function index()
	{
		return redirect('http://nudj.co');
	}

}