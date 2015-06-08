<?php namespace App\Http\Controllers\Admin;

use Illuminate\Foundation\Bus\DispatchesCommands;
use Illuminate\Foundation\Validation\ValidatesRequests;

abstract class AdminController extends \Illuminate\Routing\Controller {

	use DispatchesCommands, ValidatesRequests;

}
