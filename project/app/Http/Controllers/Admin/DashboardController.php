<?php namespace App\Http\Controllers\Admin;


class DashboardController extends AdminController {


	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('dashboard/blank');
	}


}
