<?php namespace App\Http\Controllers\Web;



class HomeController extends \Illuminate\Routing\Controller {



	public function index()
	{
		return view('web/page/downloads');
	}

}