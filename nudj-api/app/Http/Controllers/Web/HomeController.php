<?php namespace App\Http\Controllers\Web;

class HomeController extends \Illuminate\Routing\Controller {

	public function index()
	{
		return redirect('http://nudj.co');
	}

}