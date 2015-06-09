<?php namespace App\Http\Controllers\Admin;


class LogsController extends AdminController {


	public function __construct()
	{
		$this->middleware('auth');
	}

	public function index()
	{
		return view('admin/dashboard/blank');
	}


}
