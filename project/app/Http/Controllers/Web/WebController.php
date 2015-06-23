<?php namespace App\Http\Controllers\Web;


class WebController extends \Illuminate\Routing\Controller {


	public function login()
	{
		$user = array(
			"name"=>"Simo"
		);
		return view('web/page/login',$user);
	}

	public function submit()
	{
		return view('web/page/submit');
	}

}
