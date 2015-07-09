<?php namespace App\Http\Controllers\Admin;


use Illuminate\Support\Facades\Auth;

class RepairController extends AdminController {


	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('admin/page/repair',[
			'token' => Auth::user()->api_token
		]);
	}


}
