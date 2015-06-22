<?php namespace App\Http\Controllers\Web;


class WebController extends \Illuminate\Routing\Controller {


	public function login()
	{
		return view('web/page/login');
	}

	public function submit()
	{
		return view('web/page/submit');
	}

}
