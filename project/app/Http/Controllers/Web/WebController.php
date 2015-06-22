<?php namespace App\Http\Controllers\Web;


class WebController extends \Illuminate\Routing\Controller {


	public function login()
	{
		return view('web/page/login');
	}

}
